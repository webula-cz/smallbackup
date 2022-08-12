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
            'filename' => 'Soubor zálohy',
            'created_at' => 'Vytvořen',
        ],
        'control' => [
            'download' => 'stáhnout',
            'backup_now' => 'Ihned zazálohovat',
        ],
        'flash' => [
            'expired_deleted' => 'Úspěšně bylo smazáno :deleted expirovaných záloh.',
            'successfull_backup' => 'Záloha je vytvořena v souboru :file.',

            'backup_all' => 'Úspěšně bylo smazáno :deleted expirovaných záloh. Nové zálohy byly vytvořeny do souborů :files.',

            'unknown_database_driver' => 'Neznámý databázový ovladač :driver! Tento ovladač nebyl ještě implementován. Prosíme zašlete nám své PR.',
            'unknown_theme' => 'Neznámé téma! Téma s kódovým názvem :theme nebylo nalezeno.',
        ],
    ],

    'permissions' => [
        'access_settings' => 'Přístup k nastavení',
    ],

    'settings' => [
        'backup_folder' => 'Adresář pro umístění záloh',
        'cleanup_interval' => 'Interval ponechání starých záloh (dní)',
        'db_use_compression' => 'Použít ZIP kompresi',

        'db_auto' => 'Zapnout automatický režim zálohování databáze',
        'db_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',

        'db_excluded_tables' => 'Tabulky vyjmuté ze zálohování',
        'db_excluded_tables__comment' => 'Jen pro případ MySQL databází. SQLite se zálohuje celosouborově.',

        'theme_auto' => 'Zapnout automatický režim zálohování aktuálního tématu',
        'theme_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',

        'section_db' => 'Databáze',
        'section_theme' => 'Téma vzhledu',
        'section_listing' => 'Výpis záloh',
    ],
];
