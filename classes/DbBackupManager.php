<?php namespace Webula\SmallBackup\Classes;

use Db;
use File;
use Exception;
use October\Rain\Filesystem\Zip;
use Webula\SmallBackup\Models\Settings;

class DbBackupManager extends BackupManager
{
    /**
     * Backup file prefix
     *
     * @var string
     */
    protected $prefix = 'wsb-db-';

    /**
     * Backup DB by connection name (null = default)
     *
     * @param string|null $source connection name
     * @return string file with current backup
     */
    public function backup(string $source = null): string
    {
        $connectionName = $source ?: config('database.default');
        $connectionDriver = config('database.connections.' . $connectionName . '.driver');

        if ($connectionDriver == 'mysql') {
            $filename = $this->prefix . now()->format('Y-m-d') . '.sql';
            $stream = (new Drivers\Mysql(
                    Db::connection($connectionName),
                    $this->getExcludedTables()
                ))->backupStream();
            File::put(
                $this->folder . '/' . $filename,
                $stream
            );
        } elseif ($connectionDriver == 'sqlite') {
            $filename = $this->prefix . now()->format('Y-m-d') . '.sqlite';
            File::copy(
                config('database.connections.' . $connectionName . '.database'),
                $this->folder . '/' . $filename
            );
        } else {
            throw new Exception(trans('webula.smallbackup::lang.backup.flash.unknown_database_driver', ['driver' => $connectionDriver]));
        }

        if ($this->getUseCompression()) {
            $zipFilename = $filename . '.zip';
            Zip::make(
                $this->folder . '/' . $zipFilename,
                $this->folder . '/' . $filename
            );
            File::delete($this->folder . '/' . $filename);

            return $this->folder . '/' . $zipFilename;
        }

        return $this->folder . '/' . $filename;
    }

    /**
     * Get list of excluded tables from db backup
     *
     * @return array
     */
    protected function getExcludedTables(): array
    {
        return (array)Settings::get('db_excluded_tables');
    }

    /**
     * Get using compression from settings file
     *
     * @return boolean
     */
    protected function getUseCompression(): bool
    {
        return boolval(Settings::get('db_use_compression'));
    }
}