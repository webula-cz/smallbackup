<?php
return [
    'plugin' => [
        'name' => 'Small backup',
        'description' => 'Zálohování a správa zálohování databází',
    ],

    'backup' => [
        'list' => [
            'db' => 'Databáze',
            'theme' => 'Témata vzhledu',
            'backup_now' => 'Ihned zazálohovat',
            'filename' => 'Soubor zálohy',
            'created_at' => 'Vytvořen',
            'download' => 'stáhnout',
        ],
        'flash' => [
            'expired_deleted' => ':deleted expired backups were successfully deleted.',
            'successfull_backup' => 'Backup was successfully made into file :file.',

            'cleanup_and_backup' => ':deleted expired backups were successfully deleted. Backup was successfully made into files :file.',

            'unknown_database_driver' => 'Unknown database driver :driver! This driver is not implemented yet. Please send PR.',
            'unknown_theme' => 'Unknown theme! Cannot find theme with code name :theme.',
        ],
    ],

    'permissions' => [
        'access_settings' => 'Přístup k nastavení',
    ],

    'settings' => [
        'backup_folder' => 'Adresář pro umístění záloh',
        'cleanup_interval' => 'Interval ponechání starých záloh (dní)',
        'use_compression' => 'Použít ZIP kompresi',

        'db_auto' => 'Zapnout automatický režim zálohování databáze',
        'db_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace OCMS. Manuální režim vyžaduje spuštění procesu buď pomocí příkazu nebo jiným dokumentovaným způsobem.',

        'db_excluded_tables' => 'Tabulky vyjmuté ze zálohování',
        'db_excluded_tables__comment' => 'Jen pro případ MySQL databází. SQLite se zálohuje celosouborově.',

        'theme_auto' => 'Zapnout automatický režim zálohování aktuálního tématu',
        'theme_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace OCMS. Manuální režim vyžaduje spuštění procesu buď pomocí příkazu nebo jiným dokumentovaným způsobem.',

        'section_db' => 'Databáze',
        'section_theme' => 'Téma vzhledu',
        'section_listing' => 'Výpis záloh',
    ],
];
