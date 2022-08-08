<?php
return [
    'plugin' => [
        'name' => 'Small backup',
        'description' => 'Backup and backup management of databases',
    ],

    'permissions' => [
        'access_settings' => 'Manage backend preferences',
    ],

    'settings' => [
        'enabled' => 'Activate backup',
        'cleanup_interval' => 'Cleanup interval (in days)',
        'excluded_tables' => 'Tables excluded from backup',
        'use_compression' => 'Use ZIP compression',
    ],
];
