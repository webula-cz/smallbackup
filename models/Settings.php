<?php namespace Webula\SmallBackup\Models;

use System\Models\SettingModel, Db, Str;
use Cms\Classes\Theme;
use Webula\SmallBackup\Classes\PathHelper;

class Settings extends SettingModel
{
    public $settingsCode = 'webula_smallbackup_settings';

    public $settingsFields = 'fields.yaml';

    //
    // OPTIONS
    //

    /**
     * List of all database tables
     * @return array
     */
    public function getTablesOptions()
    {
        $connectionName = config('database.default'); // in backend only default one
        $connection = Db::connection($connectionName);
        $tables = $connection->getSchemaBuilder()->getTables($connection->getDatabaseName());
        return array_column($tables, 'name');
    }

    /**
     * List of additional themes
     * @return array
     */
    public function getAdditionalThemesOptions()
    {
        $availableThemes = Theme::allAvailable();
        $activeThemeCode = Theme::getActiveThemeCode();
        return array_filter(
            array_map(fn ($theme) => $theme->getDirName(), $availableThemes),
            fn ($themeCode) => $themeCode != $activeThemeCode
        );
    }

    /**
     * List of storage resources
     * @return array
     */
    public function getResourcesOptions()
    {
        return collect(config('filesystems.disks'))->where('driver', 'local')->map(function ($item) {
            $resource = array_get($item, 'root');
            $url = url('/');
            if (Str::startsWith($resource, $url)) {
                return PathHelper::normalizePath(str_after($resource, $url));
            }
            return str_after(PathHelper::normalizePath($resource), PathHelper::normalizePath(base_path()));
        })->toArray();
    }

    //
    // ACCESSORS
    //

    public function getHasTriggerAttribute(): bool
    {
        return !!$this->trigger_key && ($this->db_mode == 'trigger' || $this->theme_mode == 'trigger' || $this->storage_mode == 'trigger');
    }

}
