<?php namespace Webula\SmallBackup\Classes;

use File;
use Exception;
use ArrayIterator;
use Directory;
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

        $excludedFolders = array_merge(
            array_map(function ($folder) {
                return PathHelper::normalizePath(base_path($folder));
            }, $this->getExcludedResources()),
            [$this->folder]
        );
        $files = [];

        foreach ($folders as $_folder) {
            $files = array_merge($files,
                collect(File::allFiles($_folder))
                    ->filter(function ($file) use ($excludedFolders) {
                        return !starts_with($file->getPathname(), $excludedFolders);
                    })
                    ->map(function ($file) {
                        return $file->getPathname();
                    })
                    ->all()
            );
        }

        $name = $this->getOutputFileName($resource);
        $pathname = $this->getOutputPathName($name);

        if (!$once || !File::exists($pathname)) {
            switch ($this->getOutput()) {
                case 'tar': return $this->saveAsTar($pathname, $files, false);
                case 'tar_gz': case 'tar_bz2': return $this->saveAsTar($pathname, $files, str_after($this->getOutput(), '_'));
                case 'zip': return $this->saveAsZip($name, $pathname, $files);
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
            case 'tar': case 'tar_gz': case 'tar_bz2': $pathname .= '.tar'; break;
            case 'zip': $pathname .= '.zip'; break;
        }

        return $pathname;
    }

    /**
     * Save folderlist as TAR archive
     *
     * @param string $pathname path name
     * @param array $folders list of files
     * @param string|null $compression use compression
     * @return string file with current backup
     */
    protected function saveAsTar(string $pathname, array $files, ?string $compression = null): string
    {
        File::delete([$pathname, $pathname . '.gz', $pathname . '.bz2']);

        $archive = new PharData($pathname);
        $archive->buildFromIterator(new ArrayIterator($files), PathHelper::normalizePath(base_path()));
        if ($compression && $archive->canCompress($compression == 'gz' ? Phar::GZ : Phar::BZ2)) {
            $archive->compress($compression == 'gz' ? Phar::GZ : Phar::BZ2);
            File::delete($pathname);
            $pathname .= '.' . $compression;
        }

        return $pathname;
    }

    /**
     * Save folderlist as ZIP archive
     *
     * @param string $name filename
     * @param string $pathname path name
     * @param array $files list of files
     * @return string file with current backup
     */
    protected function saveAsZip(string $name, string $pathname, array $files): string
    {
        $files = array_map(function ($folder) {
            return PathHelper::linuxPath($folder); // FIX October Zip in Windows
        }, $files);

        Zip::make(
            $pathname,
            function ($zip) use ($files, $name) {
                $zip->folder($name, function ($zip) use ($files) {
                    foreach ($files as $file) {
                        $zip->add($file, ['basedir' => PathHelper::linuxPath(base_path())]); // FIX October Zip in Windows
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
        $data = Settings::get('storage_excluded_resources');
        return is_array($data) ? $data : explode(',', $data);
    }
}