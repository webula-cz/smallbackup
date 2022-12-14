<?php
return [
    'plugin' => [
        'name' => 'Small backup',
        'description' => 'Backup databases and themes',
    ],

    'backup' => [
        'list' => [
            'db' => 'Database backup files',
            'theme' => 'Themes backup files',
            'filename' => 'Backup file',
            'created_at' => 'Created',
        ],
        'control' => [
            'download' => 'Download',
            'backup_now' => 'Backup now',
        ],
        'flash' => [
            'expired_deleted' => ':deleted expired backups were successfully deleted.',
            'successfull_backup' => 'Backup is made in file :file.',

            'backup_all' => ':deleted expired backups were successfully deleted. Backup was successfully made into files :files.',

            'unknown_database_driver' => 'Unknown database driver :driver! This driver is not implemented yet. Please send PR.',
            'unknown_theme' => 'Unknown theme! Cannot find theme with code name :theme.',
        ],
    ],

    'permissions' => [
        'access_settings' => 'Manage backend preferences',
    ],

    'settings' => [
        'tabs' => [
            'database' => 'Database',
            'theme' => 'Theme',
            'backups' => 'Backups',
            'settings' => 'Settings',
        ],

        'backup_folder' => 'Backup folder',
        'backup_folder_comment' => 'Leave empty for default folder.',
        'cleanup_interval' => 'Cleanup interval (in days)',
        'db_use_compression' => 'Use ZIP compression',

        'db_auto' => 'Switch on auto database backup',
        'db_auto__comment' => 'The automatic mode is started once a day by the scheduler according to the October CMS documentation. Manual mode requires running the process according to the plugin documentation.',

        'db_excluded_tables' => 'Tables excluded from backup',
        'db_excluded_tables__comment' => 'Only for MySQL. SQLite is backed up as one file.',

        'db_custom_mapping' => 'Custom MySQL database Doctrine mapping',
        'db_custom_mapping__comment' => 'Database column type to be used instead of the original one when exporting database (eg. JSON to be exported as TEXT).',
        'db_custom_mapping__db_type' => 'Current database type',
        'db_custom_mapping__db_type__comment' => 'e.g. json',
        'db_custom_mapping__doctrine_type' => 'Doctrine type for backup',
        'db_custom_mapping__doctrine_type__comment' => 'e.g. text',

        'theme_auto' => 'Switch on auto theme backup',
        'theme_auto__comment' => 'The automatic mode is started once a day by the scheduler according to the October CMS documentation. Manual mode requires running the process according to the plugin documentation.',

        'section_db' => 'Database',
        'section_theme' => 'Theme',
        'section_listing' => 'List of backups',
    ],
];
