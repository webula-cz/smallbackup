<?php
return [
    'plugin' => [
        'name' => 'Small backup',
        'description' => 'Zálohování a správa zálohování databází',
    ],

    'permissions' => [
        'access_settings' => 'Přístup k nastavení',
    ],

    'settings' => [
        'enabled' => 'Zapnout zálohování',
        'cleanup_interval' => 'Interval ponechání starých záloh (dní)',
        'excluded_tables' => 'Tabulky vyjmuté ze zálohování',
        'use_compression' => 'Použít ZIP kompresi',
    ],
];
