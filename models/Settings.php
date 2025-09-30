<?php namespace Webula\SmallBackup\Models;

use Model, Db, Str;
use Webula\SmallBackup\Classes\PathHelper;

class Settings extends Model
{
    public $implement = [
        'System.Behaviors.SettingsModel',
    ];

    public $requiredPermissions = ['webula.smallbackup.access_settings'];

    public $settingsCode = 'webula_smallbackup_settings';

    public $settingsFields = 'fields.yaml';


    public function getTablesOptions()
    {
        $connectionName = config('database.default'); // in backend only default one
        $connection = Db::connection($connectionName);
        $tables = $connection->getSchemaBuilder()->getTables($connection->getDatabaseName());
        return array_column($tables, 'name');
    }


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

}
