<?php namespace Webula\SmallBackup\Classes;

use File;
use Exception;
use Cms\Classes\Theme;
use October\Rain\Filesystem\Zip;

class ThemeBackupManager extends BackupManager
{
    /**
     * Backup file prefix
     *
     * @var string
     */
    protected $prefix = 'wsb-theme-';

    /**
     * Backup Theme(s) by connection name (null = default)
     *
     * @param string|null $themeName
     * @param bool $once do not overwrite existing backup file
     * @return string backup file
     */
    public function backup(string $themeName = null, bool $once = false): string
    {
        $themeName = $themeName ?: Theme::getActiveThemeCode();

        if ($themeName && File::isDirectory(themes_path($themeName))) {
            $filename = $this->prefix . str_slug($themeName) . '-' . now()->format('Y-m-d') . '.zip';
            $pathname = $this->folder . '/' . $filename;

            if (!$once || !File::exists($pathname)) {
                Zip::make(
                    $pathname,
                    themes_path($themeName)
                );
            }

            return $pathname;
        } else {
            throw new Exception(trans('webula.smallbackup::lang.backup.flash.unknown_theme', ['theme' => $themeName]));
        }
    }
}