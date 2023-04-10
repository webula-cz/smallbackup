<?php
return [
    'plugin' => [
        'name' => 'Small backup',
        'description' => 'Zálohování databází a šablon',
    ],

    'backup' => [
        'list' => [
            'db' => 'Zálohy databáze',
            'theme' => 'Zálohy témat',
            'storage' => 'Zálohy úložiště',
            'filename' => 'Soubor zálohy',
            'created_at' => 'Vytvořen',
        ],
        'control' => [
            'download' => 'Stáhnout',
            'backup_now' => 'Ihned zazálohovat',
        ],
        'flash' => [
            'expired_deleted' => 'Úspěšně bylo smazáno :deleted expirovaných záloh.',
            'successfull_backup' => 'Záloha je vytvořena v souboru :file.',

            'backup_all' => 'Úspěšně bylo smazáno :deleted expirovaných záloh. Nové zálohy byly vytvořeny do souborů :files.',

            'nothing_to_backup' => 'Nebylo co zálohovat, záloha nevznikla.',
            'unknown_database_driver' => 'Neznámý databázový ovladač :driver! Tento ovladač nebyl ještě implementován. Prosíme zašlete nám své PR.',
            'unknown_theme' => 'Neznámé téma! Téma s kódovým názvem :theme nebylo nalezeno.',
            'unknown_resource' => 'Neznámý zdroj dat! Zdroj dat úložiště s názvem :resource nebyl nalezen.',
            'empty_resource' => 'Požadovaný zdroj dat úložiště je prázdný, není co zálohovat!',
            'unknown_output' => 'Neznámý typ výstupu, nelze provést zálohu!',
        ],
    ],

    'permissions' => [
        'access_settings' => 'Přístup k nastavení',
    ],

    'settings' => [
        'tabs' => [
            'database' => 'Databáze',
            'theme' => 'Šablona',
            'storage' => 'Úložiště',
            'settings' => 'Nastavení',
        ],

        'backup_folder' => 'Adresář pro umístění záloh',
        'backup_folder_comment' => 'Nechte prázdné pro výchozí adresář.',
        'cleanup_interval' => 'Interval ponechání starých záloh (dní)',
        'db_use_compression' => 'Použít ZIP kompresi',

        'db_auto' => 'Zapnout automatický režim zálohování databáze',
        'db_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',

        'db_excluded_tables' => 'Tabulky vyjmuté ze zálohování',
        'db_excluded_tables__comment' => 'Jen pro případ MySQL databází. SQLite se zálohuje celosouborově.',


        'db_custom_mapping' => 'Mapování typů sloupců pro MySQL Doctrine',
        'db_custom_mapping__prompt' => 'Přidat nový typ',
        'db_custom_mapping__comment' => 'Typ sloupce, který má být použitý místo originálního při exportu databáze (např. JSON exportovat jako TEXT).',
        'db_custom_mapping__db_type' => 'Databázový typ',
        'db_custom_mapping__db_type__comment' => 'např. json',
        'db_custom_mapping__doctrine_type' => 'Doctrine typ',
        'db_custom_mapping__doctrine_type__comment' => 'např. text',

        'theme_auto' => 'Zapnout automatický režim zálohování aktuálního tématu',
        'theme_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',

        'storage_auto' => 'Zapnout automatický režim zálohování úložiště',
        'storage_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',
        'storage_output' => 'Typ výstupu',
        'storage_output__tar' => 'TAR archív',
        'storage_output__tar_gz' => 'TAR komprimovaný archív',
        'storage_output__zip' => 'ZIP komprimovaný archív',

        'storage_excluded_resources' => 'Adresáře úložiště vyjmuté ze zálohování',

    ],
];
