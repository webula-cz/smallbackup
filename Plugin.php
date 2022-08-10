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
        $this->registerConsoleCommand('smallbackup.db', Console\BackupDb::class);
        $this->registerConsoleCommand('smallbackup.theme', Console\BackupTheme::class);
    }

    /**
     * Registers schedule calls implemented in this plugin.
     *
     * @return void
     */
    public function registerSchedule($schedule)
    {
        if (Models\Settings::get('db_auto')) {
            $schedule->command('smallbackup:db')->daily();
        }
        if (Models\Settings::get('theme_auto')) {
            $schedule->command('smallbackup:theme')->daily();
        }
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
                'url' => \Backend::url('webula/smallbackup/settings/update'),
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
