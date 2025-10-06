<?php namespace Webula\SmallBackup\Classes;

use File;
use Exception;
use Cms\Classes\Theme;
use Webula\SmallBackup\Models\Settings;
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
     * Backup Theme(s) by connection name (null = default + included)
     *
     * @param string|null $resource
     * @param bool $once do not overwrite existing backup file
     * @return string backup file
     */
    public function backup(string $resource = null, bool $once = false): string
    {
        if ($resource) {
            $themes[] = $resource;
        } else {
            $themes = [
                Theme::getActiveThemeCode(),
                ...$this->getAdditionalThemes()
            ];
        }

        $pathnames = [];
        foreach ($themes as $themeName) {
            if ($themeName && File::isDirectory(themes_path($themeName))) {
                $filename = $this->prefix . str_slug($themeName) . '-' . now()->format('Y-m-d') . '.zip';
                $pathname = $this->folder . DIRECTORY_SEPARATOR . $filename;

                if (!$once || !File::exists($pathname)) {
                    Zip::make(
                        $pathname,
                        themes_path($themeName)
                    );
                }
                $pathnames[] = $pathname;
            } else {
                throw new Exception(trans('webula.smallbackup::lang.backup.flash.unknown_theme', ['theme' => $themeName]));
            }
        }

        return implode(', ', $pathnames);
    }

    /**
     * Get list of additional themes for theme backup
     *
     * @return array
     */
    protected function getAdditionalThemes(): array
    {
        $data = Settings::get('theme_additional_themes');
        return $data
            ? (is_array($data) ? $data : explode(',', $data))
            : [];
    }
}