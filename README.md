# smallbackup-plugin
Default folder: `storage/app/uploads/protected/backup`

## Console command
Záloha databáze: `php artisan smallbackup:db [connectionName] [--no-cleanup]` (connectionName je název připojení v config/database.php; vynechat = defaultní)

Záloha tématu vzhledu: `php artisan smallbackup:theme [themeName] [--no-cleanup]` (themeName je složka tématu v themes/; vynechat = aktivní téma)

## Scheduler
V nastavení lze zapnout automatický režim, ve kterém je naplánována úloha zálohování na jednou denně při spouštění cronem - viz [dokumentace October CMS](https://docs.octobercms.com/1.x/setup/installation.html#review-configuration).

## Artisan stránka
Lze použít helpery (pozor, nutno vnutit do composer autoloadu - nejlépe pomocí `composer update`). Chyby píší automaticky do logu.
```title = "artisan"
url = "/artisan/schedule"
is_hidden = 0
==
<?php
    function onStart()
    {
        wsb_backup_db();
        wsb_backup_theme();
    }
?>
==
```