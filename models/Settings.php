<?php namespace Webula\SmallBackup\Models;

use Model;

class Settings extends Model
{
    public $implement = [
        'System.Behaviors.SettingsModel',
    ];

    public $requiredPermissions = ['webula.smallbackup.access_settings'];

    public $settingsCode = 'webula_smallbackup_settings';

    public $settingsFields = 'fields.yaml';


    public function getExcludedTablesOptions()
    {
        return \Db::connection()->getDoctrineSchemaManager()->listTableNames();
    }

}
