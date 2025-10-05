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
            'successfull_backup' => 'Backup was made in file :file.',
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
            'settings' => 'Settings',
        ],

        'backup_folder' => 'Backup folder',
        'backup_folder_comment' => 'Leave empty for default folder.',
        'cleanup_interval' => 'Cleanup interval (in days)',
        'db_use_compression' => 'Use ZIP compression',
        'db_mode' => 'Database backup mode',
        'db_mode__manual' => 'Manual',
        'db_mode__manual__comment' => 'Manual mode requires the user to start the process according to the plugin documentation.',
        'db_mode__schedule' => 'Automatically by scheduler',
        'db_mode__schedule__comment' => 'Automatic mode is run once daily by the scheduler according to October CMS documentation.',
        'db_mode__trigger' => 'By external link',
        'db_mode__trigger__comment' => 'Backup is triggered by an external link (see plugin settings for details).',
        'db_excluded_tables' => 'Tables excluded from backup',
        'db_excluded_tables__comment' => 'Only for MySQL databases. SQLite is backed up as a whole file.',

        'theme_mode' => 'Theme backup mode',
        'theme_mode__manual' => 'Manual',
        'theme_mode__manual__comment' => 'Manual mode requires the user to start the process according to the plugin documentation.',
        'theme_mode__schedule' => 'Automatically by scheduler',
        'theme_mode__schedule__comment' => 'Automatic mode is run once daily by the scheduler according to October CMS documentation.',
        'theme_mode__trigger' => 'By external link',
        'theme_mode__trigger__comment' => 'Backup is triggered by an external link (see plugin settings for details).',
        'theme_additional_themes' => 'Include inactive themes',
        'theme_additional_themes__comment' => 'By default only the active theme is backed up. Select additional themes to include in the backup.',

        'storage_mode' => 'Storage backup mode',
        'storage_mode__manual' => 'Manual',
        'storage_mode__manual__comment' => 'Manual mode requires the user to start the process according to the plugin documentation.',
        'storage_mode__schedule' => 'Automatically by scheduler',
        'storage_mode__schedule__comment' => 'Automatic mode is run once daily by the scheduler according to October CMS documentation.',
        'storage_mode__trigger' => 'By external link',
        'storage_mode__trigger__comment' => 'Backup is triggered by an external link (see plugin settings for details).',
        'storage_output' => 'Output type',
        'storage_output__tar_unsafe' => 'TAR archive without filename length checks (faster)',
        'storage_output__tar' => 'Standard TAR archive',
        'storage_output__tar_gz' => 'TAR archive compressed with zlib',
        'storage_output__tar_bz2' => 'TAR archive compressed with bzip2',
        'storage_output__zip' => 'ZIP compressed archive',
        'storage_output__comment' => 'Maximum filename length for standard TAR archive is 256 characters. Longer names will be truncated.',
        'storage_excluded_resources' => 'Storage directories excluded from backup',
        'storage_auto' => 'Switch on auto storage backup',
        'storage_auto__comment' => 'The automatic mode is started once a day by the scheduler according to the October CMS documentation. Manual mode requires running the process according to the plugin documentation.',

        'trigger_key' => 'Variable key for triggering external backup',
        'trigger_key__comment' => 'This key is used to build the full URL for triggering backups of selected resources. The complete URL then has the form <strong>'
            . config('app.url') . '/'
            . config('webula.smallbackup::trigger.url_prefix')
            . '{variable key}</strong><br />The fixed part of the path can be changed in the configuration file.',
    ],
];
