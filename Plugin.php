<?php namespace Webula\SmallBackup;

use System\Classes\PluginBase;

/**
 * SmallBackup Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'webula.smallbackup::lang.plugin.name',
            'description' => 'webula.smallbackup::lang.plugin.description',
            'author' => 'Webula',
            'icon' => 'icon-database'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommand('smallbackup.backup', Console\Backup::class);
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        //dump(\App::make(Classes\DbBackupManager::class)->backup());
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [];
    }

    /**
     * Registers any back-end setting used by this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'webula.smallbackup::lang.plugin.name',
                'description' => 'webula.smallbackup::lang.plugin.description',
                'category'    => 'Small plugins',
                'icon' => 'icon-database',
                'class' => Models\Settings::class,
                'keywords' => 'database backup',
                'order' => 991,
                'permissions' => ['webula.smallbackup.access_settings'],
            ]
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'webula.smallbackup.access_settings' => [
                'label' => 'webula.smallbackup::lang.permissions.access_settings',
                'tab' => 'webula.smallbackup::lang.plugin.name',
            ],
        ];

    }
}
