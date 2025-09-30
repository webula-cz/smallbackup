<?php
return [
    'plugin' => [
        'name' => 'Small backup',
        'description' => 'Zálohování databází, šablon a úložiště',
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
            'failed_backup' => 'Záloha selhala: :error.',

            'backup_all' => 'Úspěšně bylo smazáno :deleted expirovaných záloh. Nové zálohy byly vytvořeny do souborů :files.',

            'nothing_to_backup' => 'Nebylo co zálohovat, záloha nevznikla.',
            'unknown_database_driver' => 'Neznámý databázový ovladač :driver! Tento ovladač nebyl ještě implementován. Prosíme zašlete nám své PR.',
            'unknown_theme' => 'Neznámé téma! Téma s kódovým názvem :theme nebylo nalezeno.',
            'unknown_resource' => 'Neznámý zdroj dat! Zdroj dat úložiště s názvem :resource nebyl nalezen.',
            'empty_resource' => 'Požadovaný zdroj dat úložiště je prázdný, není co zálohovat!',
            'empty_files' => 'Zdroje dat úložiště neobsahují žádne soubory, není co zálohovat!',
            'unknown_output' => 'Neznámý typ výstupu, nelze provést zálohu!',

            'truncated_filenames' => 'Tyto názvy souborů musely v TAR archívu zkráceny: :filenames',
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
            // 'settings' => 'Nastavení',
        ],

        'backup_folder' => 'Adresář pro umístění záloh',
        'backup_folder_comment' => 'Nechte prázdné pro výchozí adresář.',
        'cleanup_interval' => 'Interval ponechání starých záloh (dní)',
        'db_use_compression' => 'Použít ZIP kompresi',

        'db_auto' => 'Zapnout automatický režim zálohování databáze',
        'db_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',

        'db_excluded_tables' => 'Tabulky vyjmuté ze zálohování',
        'db_excluded_tables__comment' => 'Jen pro případ MySQL databází. SQLite se zálohuje celosouborově.',

        'theme_auto' => 'Zapnout automatický režim zálohování aktuálního tématu',
        'theme_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',

        'storage_auto' => 'Zapnout automatický režim zálohování úložiště',
        'storage_auto__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS. Manuální režim vyžaduje spuštění procesu dle dokumentace pluginu.',
        'storage_output' => 'Typ výstupu',
        'storage_output__tar_unsafe' => 'TAR archív bez kontroly délky názvů souborů (rychlejší)',
        'storage_output__tar' => 'TAR archív standardní',
        'storage_output__tar_gz' => 'TAR archív komprimovaný pomocí zlib',
        'storage_output__tar_bz2' => 'TAR archív komprimovaný pomocí bzip2',
        'storage_output__zip' => 'ZIP komprimovaný archív',
        'storage_output__comment' => 'Maximální délka názvů souborů u standardního TAR archívu je 256 znaků. Delší názvy se oříznou.',

        'storage_excluded_resources' => 'Adresáře úložiště vyjmuté ze zálohování',

    ],
];
