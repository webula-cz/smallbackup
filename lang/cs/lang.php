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
            'successfull_backup' => 'Záloha byla vytvořena v souboru :file.',
            'failed_backup' => 'Záloha selhala: :error.',

            'backup_all' => 'Úspěšně bylo smazáno :deleted expirovaných záloh. Nové zálohy byly vytvořeny v souborech :files.',

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
            'settings' => 'Nastavení',
        ],

        'backup_folder' => 'Adresář pro umístění záloh',
        'backup_folder_comment' => 'Nechte prázdné pro výchozí adresář.',
        'cleanup_interval' => 'Interval ponechání starých záloh (dní)',
        'db_use_compression' => 'Použít ZIP kompresi',
        'db_mode' => 'Režim zálohování databáze',
        'db_mode__manual' => 'Manuální',
        'db_mode__manual__comment' => 'Manuální režim vyžaduje uživatelské spuštění procesu dle dokumentace pluginu.',
        'db_mode__schedule' => 'Automaticky plánovačem',
        'db_mode__schedule__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS.',
        'db_mode__trigger' => 'Externím odkazem',
        'db_mode__trigger__comment' => 'Zálohování je spouštěno externím odkazem (více v nastavení pluginu).',
        'db_excluded_tables' => 'Tabulky vyjmuté ze zálohování',
        'db_excluded_tables__comment' => 'Jen pro případ MySQL databází. SQLite se zálohuje celosouborově.',

        'theme_mode' => 'Režim zálohování témat',
        'theme_mode__manual' => 'Manuální',
        'theme_mode__manual__comment' => 'Manuální režim vyžaduje uživatelské spuštění procesu dle dokumentace pluginu.',
        'theme_mode__schedule' => 'Automaticky plánovačem',
        'theme_mode__schedule__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS.',
        'theme_mode__trigger' => 'Externím odkazem',
        'theme_mode__trigger__comment' => 'Zálohování je spouštěno externím odkazem (více v nastavení pluginu).',
        'theme_additional_themes' => 'Připojit neaktivní témata',
        'theme_additional_themes__comment' => 'Automaticky je zálohováno jen aktivní téma. Vyberte další témata, která chcete připojit k zálohování.',

        'storage_mode' => 'Režim zálohování úložiště',
        'storage_mode__manual' => 'Manuální',
        'storage_mode__manual__comment' => 'Manuální režim vyžaduje uživatelské spuštění procesu dle dokumentace pluginu.',
        'storage_mode__schedule' => 'Automaticky plánovačem',
        'storage_mode__schedule__comment' => 'Automatický režim je spouštěn jednou denně plánovačem dle dokumentace October CMS.',
        'storage_mode__trigger' => 'Externím odkazem',
        'storage_mode__trigger__comment' => 'Zálohování je spouštěno externím odkazem (více v nastavení pluginu).',
        'storage_output' => 'Typ výstupu',
        'storage_output__tar_unsafe' => 'TAR archív bez kontroly délky názvů souborů (rychlejší)',
        'storage_output__tar' => 'TAR archív standardní',
        'storage_output__tar_gz' => 'TAR archív komprimovaný pomocí zlib',
        'storage_output__tar_bz2' => 'TAR archív komprimovaný pomocí bzip2',
        'storage_output__zip' => 'ZIP komprimovaný archív',
        'storage_output__comment' => 'Maximální délka názvů souborů u standardního TAR archívu je 256 znaků. Delší názvy se oříznou.',
        'storage_excluded_resources' => 'Adresáře úložiště vyjmuté ze zálohování',

        'trigger_key' => 'Variabilní klíč pro spouštění externího zálohování',
        'trigger_key__comment' => 'Tímto klíčem vznikne plná URL adresa spouštěče zálohování vybraných zdrojů. Celá adresa má potom tvar <strong>'
            . config('app.url') . '/'
            . config('webula.smallbackup::trigger.url_prefix')
            . '{variabilní klíč}</strong><br />Fixní část adresy je možné změnit v konfiguračním souboru.',
    ],
];
