<?php namespace Webula\SmallBackup\Classes;

use File;
use Exception;
use October\Rain\Filesystem\Zip;
use Webula\SmallBackup\Models\Settings;

class StorageBackupManager extends BackupManager
{
    /**
     * Backup file prefix
     *
     * @var string
     */
    protected $prefix = 'wsb-storage-';

    /**
     * Backup Storage(s) by resource name (null = all)
     *
     * @param string|null $resource resource
     * @param bool $once do not overwrite existing backup file
     * @return string backup file
     */
    public function backup(string $resource = null, bool $once = false): string
    {
        if ($resource) {
            $path = array_get($this->getResources(), $resource);
            if (!$path) {
                throw new Exception(trans('webula.smallbackup::lang.backup.flash.unknown_resource', ['resource' => $resource]));
            }
            $folders[] = $path;
        } else {
            $folders = array_diff($this->getResources(), $this->getExcludedResources());
        }

        $folders = collect($folders)->map(function ($folder) {
            return self::normalizePath(base_path($folder));
        })->filter(function ($folder) {
            return File::isDirectory($folder);
        })->all();

        if (empty($folders)) {
            throw new Exception(trans('webula.smallbackup::lang.backup.flash.empty_resource'));
        }

        $filename = $this->prefix . str_slug($resource ?: 'all') . '-' .  now()->format('Y-m-d') . '.zip';
        $pathname = $this->folder . '/' . $filename;

        if (!$once || !File::exists($pathname)) {
            Zip::make(
                $pathname,
                $folders,
                ['basedir' => self::normalizePath(base_path())]
            );
        }

        return $pathname;
    }

    /**
     * Get list of available resources
     *
     * @return array
     */
    protected function getResources(): array
    {
        return (array)Settings::instance()->getResourcesOptions();
    }

    /**
     * Get list of excluded folders from storage backup
     *
     * @return array
     */
    protected function getExcludedResources(): array
    {
        return (array)Settings::get('storage_excluded_resources');
    }

    //
    // STATIC HELPERS
    //

    public static function normalizePath($path): string
    {
        return rtrim(preg_replace('#([\\\\/]+)#', '/', $path), '/');
    }
}