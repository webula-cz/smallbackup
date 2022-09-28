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
        ],

        'backup_folder' => 'Backup folder',
        'backup_folder_comment' => 'Leave empty for default folder.',
        'cleanup_interval' => 'Cleanup interval (in days)',
        'db_use_compression' => 'Use ZIP compression',

        'db_auto' => 'Switch on auto database backup',
        'db_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',

        'db_excluded_tables' => 'Tables excluded from backup',
        'db_excluded_tables__comment' => 'Only for MySQL. SQLite is backed up as one file.',

        'theme_auto' => 'Switch on auto theme backup',
        'theme_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',

        'section_db' => 'Database',
        'section_theme' => 'Theme',
        'section_listing' => 'List of backups',
    ],
];
