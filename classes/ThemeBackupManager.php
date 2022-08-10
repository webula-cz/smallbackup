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
     * @return string backup file
     */
    public function backup(string $themeName = null): string
    {
        $themeName = $themeName ?: Theme::getActiveThemeCode();

        if ($themeName && File::isDirectory(themes_path($themeName))) {
            $filename = $this->prefix . str_slug($themeName) . '-' . now()->format('Y-m-d') . '.zip';
            Zip::make(
                $this->folder . '/' . $filename,
                themes_path($themeName)
            );
        } else {
            throw new Exception(trans('webula.smallbackup::lang.backup.flash.unknown_theme', ['theme' => $themeName]));
        }

        return $this->folder . '/' . $filename;
    }
}