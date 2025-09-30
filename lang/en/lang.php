<?php
return [
    'plugin' => [
        'name' => 'Small backup',
        'description' => 'Backup databases, themes and storage',
    ],

    'backup' => [
        'list' => [
            'db' => 'Database backup files',
            'theme' => 'Themes backup files',
            'storage' => 'Storage backup files',
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
            'failed_backup' => 'Backup failed: :error.',

            'backup_all' => ':deleted expired backups were successfully deleted. Backup was successfully made into files :files.',

            'nothing_to_backup' => 'Nothing to backup.',
            'unknown_database_driver' => 'Unknown database driver :driver! This driver is not implemented yet. Please send PR.',
            'unknown_theme' => 'Unknown theme! Cannot find theme with code name :theme.',
            'unknown_resource' => 'Unknown storage resource! Cannot find storage resource :resource.',
            'empty_resource' => 'This resource is empty, nothing to backup!',
            'empty_files' => 'Storage resources does not contain any files, nothing to backup!',
            'unknown_output' => 'Unknown output type, cannot create backup!',

            'truncated_filenames' => 'This filenames were truncated when creating TAR archive: :filenames',
        ],
    ],

    'permissions' => [
        'access_settings' => 'Manage backend preferences',
    ],

    'settings' => [
        'tabs' => [
            'database' => 'Database',
            'theme' => 'Theme',
            'storage' => 'Storage',
            // 'settings' => 'Settings',
        ],

        'backup_folder' => 'Backup folder',
        'backup_folder_comment' => 'Leave empty for default folder.',
        'cleanup_interval' => 'Cleanup interval (in days)',
        'db_use_compression' => 'Use ZIP compression',

        'db_auto' => 'Switch on auto database backup',
        'db_auto__comment' => 'The automatic mode is started once a day by the scheduler according to the October CMS documentation. Manual mode requires running the process according to the plugin documentation.',

        'db_excluded_tables' => 'Tables excluded from backup',
        'db_excluded_tables__comment' => 'Only for MySQL. SQLite is backed up as one file.',

        'theme_auto' => 'Switch on auto theme backup',
        'theme_auto__comment' => 'The automatic mode is started once a day by the scheduler according to the October CMS documentation. Manual mode requires running the process according to the plugin documentation.',

        'storage_auto' => 'Switch on auto storage backup',
        'storage_auto__comment' => 'The automatic mode is started once a day by the scheduler according to the October CMS documentation. Manual mode requires running the process according to the plugin documentation.',
        'storage_output' => 'Output type',
        'storage_output__tar_unsafe' => 'TAR archive without filename length check (faster)',
        'storage_output__tar' => 'TAR archive standard',
        'storage_output__tar_gz' => 'TAR archive compressed with zlib',
        'storage_output__tar_bz2' => 'TAR archive compressed with bzip2',
        'storage_output__zip' => 'ZIP archive',
        'storage_output__comment' => 'Maximum length of standard TAR archive file name is 256 characters. Longer names will be truncated.',

        'storage_excluded_resources' => 'Storage folders removed from backup',

    ],
];
