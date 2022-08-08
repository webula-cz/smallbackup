<?php namespace Webula\SmallBackup\Classes;

use File, Str;
use Carbon\Carbon;
use Db;
use Exception;
use October\Rain\Filesystem\Zip;
use Webula\SmallBackup\Models\Settings;

class DbBackupManager
{

    /**
     * Backup folder
     *
     * @var string
     */
    protected $folder;


    public function __construct(string $folder = 'app/uploads/protected/backup')
    {
        $this->folder = trim($folder, '/');

        if (!File::isDirectory(storage_path($this->folder)))  {
            File::makeDirectory(storage_path($this->folder), config('cms.defaultMask.folder'), true);
        }
    }


    /**
     * Backup DB by connection name (null = default)
     *
     * @param string|null $connectionName
     * @return string backup file
     */
    public function backup(string $connectionName = null): string
    {
        $connectionName = $connectionName ?: config('database.default');
        $connectionDriver = config('database.connections.' . $connectionName . '.driver');

        if ($connectionDriver == 'mysql') {
            $filename = 'wsb-' . now()->format('Y-m-d') . '.sql';
            $stream = (new MysqlBackup(Db::connection($connectionName)))
                ->backupStream();
            File::put(
                storage_path($this->folder . '/' . $filename),
                $stream
            );
        } elseif ($connectionDriver == 'sqlite') {
            $filename = 'wsb-' . now()->format('Y-m-d') . '.sqlite';
            File::copy(
                config('database.connections.' . $connectionName . '.database'),
                storage_path($this->folder . '/' . $filename)
            );
        } else {
            throw new Exception("Unknown database driver {$connectionDriver}! This driver is not implemented yet.");
        }

        if ($this->getUseCompression()) {
            $zipFilename = $filename . '.zip';
            Zip::make(
                storage_path($this->folder . '/' . $zipFilename),
                storage_path($this->folder . '/' . $filename)
            );
            File::delete(storage_path($this->folder . '/' . $filename));

            return $zipFilename;
        }

        return $filename;
    }

    /**
     * Cleanup old backups
     *
     * @return integer Number of deleted backups
     */
    public function clear(): int
    {
        $counter = 0;
        foreach (File::files(storage_path($this->folder)) as $file) {
            $outdated = Str::startsWith($file->getFilename(), 'wsb-')
                && Carbon::createFromTimestamp($file->getCTime(), config('app.timezone'))
                    ->lt(now()->subDays($this->getCleanupInterval())
                );

            if ($outdated) {
                File::delete($file->getPathname());
                $counter++;
            }
        }

        return $counter;
    }


    protected function getCleanupInterval(): int
    {
        return intval(Settings::get('cleanup_interval', 7));
    }


    protected function getUseCompression(): bool
    {
        return boolval(Settings::get('use_compression'));
    }
}