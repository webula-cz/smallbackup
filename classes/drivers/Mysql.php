<?php namespace Webula\SmallBackup\Classes\Drivers;

use Illuminate\Database\Connection;

class Mysql implements Contracts\BackupStream
{
    /**
     * Connection handler
     *
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * List of excluded tables from stream
     *
     * @var array
     */
    protected $excludedTables = [];


    public function __construct(Connection $connection, array $excludedTables = [], array $customMapping = [])
    {
        $this->connection = $connection;
        $this->excludedTables = $excludedTables;

        $this->syncPlatformMapping($customMapping);
    }

    /**
     * Return backup stream
     *
     * @return string
     */
    public function backupStream(): string
    {
        $stream =
            $this->header() .
            $this->line() . PHP_EOL
        ;

        $tables = collect($this->getListOfTables())
            ->map(function ($item) {
                return $item->getName();
            })
            ->diff($this->excludedTables)
            ->toArray();

        foreach ($tables as $table) {
            $stream .= $this->comment('Table structure: ' . $this->wrapTable($table)) . PHP_EOL .
                $this->getDropTableStatement($table) . PHP_EOL .
                $this->getCreateTableStatement($table) . PHP_EOL .
                $this->comment('Table data: ' . $this->wrapTable($table)) . PHP_EOL .
                $this->getInsertStatement($table) . PHP_EOL .
                $this->line() . PHP_EOL
            ;
        }

        $views = collect($this->getListOfViews())
            ->map(function ($item) {
                return $item->getName();
            })
            ->diff($this->excludedTables)
            ->toArray();

        foreach ($views as $view) {
            $stream .= $this->comment('View structure: ' . $this->wrapTable($view)) . PHP_EOL .
                $this->getDropViewStatement($view) . PHP_EOL .
                $this->getCreateViewStatement($view) . PHP_EOL .
                $this->line() . PHP_EOL
            ;
        }

        $stream .= $this->footer();

        return $stream;
    }

    /**
     * Get sql dump header
     *
     * @return string
     */
    protected function header(): string
    {
        return "-- MySQL dump by Webula.SmallBackup plugin for October CMS 1.x" . PHP_EOL
            . "-- Created: " . now()->format('d.m.Y H:i:s') . PHP_EOL
            . PHP_EOL
            . "SET FOREIGN_KEY_CHECKS=0;" . PHP_EOL
            . "START TRANSACTION;" . PHP_EOL
            . PHP_EOL
            . "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;" . PHP_EOL
            . "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;" . PHP_EOL
            . "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;" . PHP_EOL
            . "/*!40101 SET NAMES {$this->getCharset()} */;" . PHP_EOL
            . PHP_EOL
            . $this->comment('Database: ' . $this->wrapTable($this->getDatabaseName()))
            . PHP_EOL
        ;
    }

    /**
     * Get sql dump footer
     *
     * @return string
     */
    protected function footer(): string
    {
        return "SET FOREIGN_KEY_CHECKS=1;" . PHP_EOL
            . "COMMIT;" . PHP_EOL
            . PHP_EOL
            . "/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;" . PHP_EOL
            . "/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;" . PHP_EOL
            . "/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;" . PHP_EOL
            . PHP_EOL
        ;
    }

    /**
     * Format sql dump comment
     *
     * @var string $text
     * @return string
     */
    protected function comment(string $text): string
    {
        return "--" . PHP_EOL . "-- {$text}" . PHP_EOL . "--" . PHP_EOL;
    }

    /**
     * Write sql dump horizontal rule
     *
     * @return string
     */
    protected function line(): string
    {
        return "-- --------------------------------------------------------" . PHP_EOL;
    }

    /**
     * Get full insert statement for table
     *
     * @param string $table
     * @return string
     */
    protected function getInsertStatement(string $table): string
    {
        $columns = $this->getListOfColumns($table);
        $chunks = collect($this->fetchAll($table, $columns))->chunk(500);
        $output = '';
        foreach ($chunks as $chunk) {
            $output .= "INSERT INTO " . $this->wrapTable($table) . " (" . $this->wrap($columns) . ") VALUES";
            foreach ($chunk as $row) {
                if ($chunk->first() != $row) {
                    $output .= ',';
                }
                $row = collect($row)->map(function ($value) {
                    return $this->quote($value);
                });
                $output .= PHP_EOL . "(" . $row->implode(', ') . ")";
            }
            $output .= ";" . PHP_EOL;
        }

        return $output;
    }

    /**
     * Get full drop statement for table
     *
     * @param string $table
     * @param boolean $ifExists
     * @return string
     */
    protected function getDropTableStatement(string $table): string
    {
        return "DROP TABLE IF EXISTS " . $this->wrapTable($table) . ";";
    }

    /**
     * Get full create statement for table
     *
     * @param string $table
     * @return string
     */
    protected function getCreateTableStatement(string $table): string
    {
        $dynamicObj = $this->connection->selectOne("SHOW CREATE TABLE " . $this->wrapTable($table));
        return object_get($dynamicObj, 'Create Table') . ';' . PHP_EOL;
    }

    /**
     * Get full drop statement for view
     *
     * @param string $view
     * @param boolean $ifExists
     * @return string
     */
    protected function getDropViewStatement(string $view, $ifExists = true): string
    {
        if ($ifExists) {
            return "DROP VIEW IF EXISTS " . $this->wrapTable($view) . ";";
        } else {
            return "DROP VIEW " . $this->wrapTable($view) . ";";
        }
    }

    /**
     * Get full create statement for view
     *
     * @param string $view
     * @return string
     */
    protected function getCreateViewStatement(string $view): string
    {
        $dynamicObj = $this->connection->selectOne("SHOW CREATE TABLE " . $this->wrapTable($view));
        return object_get($dynamicObj, 'Create View') . ';' . PHP_EOL;
    }

    /**
     * Fetch all data
     *
     * @param string $table
     * @param array|null $columns
     * @return array
     */
    protected function fetchAll(string $table, array $columns = null): array
    {
        if (!empty($columns)) {
            return $this->connection->select("SELECT " . $this->wrap($columns) . " FROM " . $this->wrapTable($table));
        } else {
            return $this->connection->select("SELECT * FROM " . $this->wrapTable($table));
        }
    }

    /**
     * Get database name
     *
     * @return string
     */
    protected function getDatabaseName(): string
    {
        return $this->connection->getDatabaseName();
    }

    /**
     * Get list of tables
     *
     * @return array
     */
    protected function getListOfTables(): array
    {
        return $this->connection->getDoctrineSchemaManager()->listTables();
    }

    /**
     * Get list of views
     *
     * @return array
     */
    protected function getListOfViews(): array
    {
        return $this->connection->getDoctrineSchemaManager()->listViews();
    }

    /**
     * Get list of columns
     *
     * @param string $table
     * @return array
     */
    protected function getListOfColumns(string $table): array
    {
        return collect($this->connection->getDoctrineSchemaManager()->listTableColumns($table))
            ->map(function ($item) {
                return $item->getName();
            })
            ->toArray();
    }

    /**
     * Get charset
     *
     * @return string
     */
    protected function getCharset(): string
    {
        return $this->connection->getConfig('charset');
    }


    /**
     * Sync doctrine platform mapping
     *
     * @param array $customMapping [original_type => backup_type]
     * @return void
     */
    protected function syncPlatformMapping(array $customMapping = []): void
    {
        $platform = $this->connection->getDoctrineSchemaManager()->getDatabasePlatform();
        if (!$platform->hasDoctrineTypeMappingFor('json')) {
            $platform->registerDoctrineTypeMapping('json', 'text');
        }
        if (!$platform->hasDoctrineTypeMappingFor('enum')) {
            $platform->registerDoctrineTypeMapping('enum', 'string');
        }
        if (!empty($customMapping)) {
            foreach ($customMapping as $db_type => $doctrine_type) {
                $platform->registerDoctrineTypeMapping($db_type, $doctrine_type);
            }
        }
    }


    /**
     * Wrap table/database name
     *
     * @param string $name
     * @return string
     */
    protected function wrapTable(string $name): string
    {
        return $this->connection->getQueryGrammar()->wrapTable($name);
    }

    /**
     * Wrap column name of array of column names
     *
     * @param string|array $name
     * @return string
     */
    protected function wrap($name): string
    {
        if (is_array($name)) {
            return $this->connection->getQueryGrammar()->columnize($name);
        }
        return $this->connection->getQueryGrammar()->wrap($name);
    }

    /**
     * Quote value
     *
     * @param mixed $value
     * @return string
     */
    protected function quote($value): string
    {
        if (is_numeric($value)) {
            return strval($value);
        } elseif (is_bool($value)) {
            return strval(intval($value));
        } elseif (is_null($value)) {
            return 'NULL';
        }
        return $this->connection->getPdo()->quote($value);
    }


}