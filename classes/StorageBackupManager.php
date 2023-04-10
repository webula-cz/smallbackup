<?php namespace Webula\SmallBackup\Classes;

use File;
use Exception;
use ArrayIterator;
use October\Rain\Filesystem\Zip;
use Phar, PharData;
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
     * @return string file with current backup
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
            return PathHelper::normalizePath(base_path($folder));
        })->filter(function ($folder) {
            return File::isDirectory($folder);
        })->all();

        if (empty($folders)) {
            throw new Exception(trans('webula.smallbackup::lang.backup.flash.empty_resource'));
        }

        $name = $this->getOutputFileName($resource);
        $pathname = $this->getOutputPathName($name);

        if (!$once || !File::exists($pathname)) {
            switch ($this->getOutput()) {
                case 'tar': return $this->saveAsTar($pathname, $folders, false);
                case 'tar_gz': return $this->saveAsTar($pathname, $folders, true);
                case 'zip': return $this->saveAsZip($name, $pathname, $folders);
                default: throw new Exception(trans('webula.smallbackup::lang.backup.flash.unknown_output'));
            }
        }

        return $pathname;
    }

    /**
     * Get output file name
     *
     * @param string|null $resource
     * @return string
     */
    protected function getOutputFileName(string $resource = null): string
    {
        return $this->prefix . str_slug($resource ?: 'all') . '-' .  now()->format('Y-m-d');
    }

    /**
     * Get output pathname
     *
     * @param string $name
     * @return string
     */
    protected function getOutputPathName(string $name): string
    {
        $pathname = $this->folder . DIRECTORY_SEPARATOR . $name;

        switch ($this->getOutput()) {
            case 'tar': case 'tar_gz': $pathname .= '.tar'; break;
            //case 'tar_gz': $pathname .= '.tar.gz'; break;
            case 'zip': $pathname .= '.zip'; break;
        }

        return $pathname;
    }

    /**
     * Save folderlist as TAR archive
     *
     * @param string $pathname path name
     * @param array $folders list of folders
     * @param boolean $gz_compression use GZ compression
     * @return string file with current backup
     */
    protected function saveAsTar(string $pathname, array $folders, bool $gz_compression = false): string
    {
        $files = [];
        foreach ($folders as $folder) {
            $files = array_merge($files, array_map(function ($file) use ($folder) { return $folder . DIRECTORY_SEPARATOR . $file; }, array_diff(scandir($folder), ['.', '..'])));
        }

        File::delete([$pathname, $pathname . '.gz']);

        $archive = new PharData($pathname);
        $archive->buildFromIterator(new ArrayIterator($files), PathHelper::normalizePath(base_path()));
        if ($gz_compression && $archive->canCompress(Phar::GZ)) {
            $archive->compress(Phar::GZ);
            File::delete($pathname);
            $pathname .= '.gz';
        }

        return $pathname;
    }

    /**
     * Save folderlist as ZIP archive
     *
     * @param string $name filename
     * @param string $pathname path name
     * @param array $folders list of folders
     * @return string file with current backup
     */
    protected function saveAsZip(string $name, string $pathname, array $folders): string
    {
        $folders = collect($folders)->map(function ($folder) {
            return PathHelper::linuxPath($folder); // FIX Zip in Windows
        })->all();

        Zip::make(
            $pathname,
            function ($zip) use ($folders, $name) {
                $zip->folder($name, function ($zip) use ($folders) {
                    foreach ($folders as $_folder) {
                        $zip->add($_folder, ['basedir' => PathHelper::linuxPath(base_path())]);
                    }
                });
            }
        );

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
     * Get output type of storage backup
     *
     * @return string
     */
    protected function getOutput(): string
    {
        return (string)Settings::get('storage_output', 'tar');
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
}