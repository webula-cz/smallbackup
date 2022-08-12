# smallbackup-plugin
Plugin má za úkol jednoduše zazálohovat databázi a složku s tématem vzhledu, uchovat tuto zálohu po určený počet dní a umožnit její snadné stáhnutí v backendu October CMS.

Defaultní místo pro zálohy je složka `storage/app/uploads/protected/backup` a interval ponechání zálohy 7 dní.

Zálohování je možné vyvolat automaticky nebo ručně, dle nastavení v backendu OctoberCMS. Manuální řešení poskytuje použití příkazu nebo helperů (viz níže).

## Automatické zálohování
### Scheduler
V nastavení lze zapnout automatický režim, ve kterém je naplánována úloha zálohování 1x denně při spouštění cronem - viz [dokumentace October CMS](https://docs.octobercms.com/1.x/setup/installation.html#review-configuration).

## Manuální zálohování

### Backend settings
V backendu je v nastavení tohoto pluginu tlačítko pro okamžité provedení zálohy.

### Console command
Příkaz pro zálohu databáze je `php artisan smallbackup:db [connectionName] [--no-cleanup] [--once]` (connectionName je název připojení v config/database.php; vynechat = defaultní)

Příkaz pro zálohu tématu vzhledu: `php artisan smallbackup:theme [themeName] [--no-cleanup] [--once]` (themeName je složka tématu v themes/; vynechat = aktivní téma)

### Artisan stránka
Na artisan/schedule CMS stránce lze použít helpery. Chyby zapisují automaticky do error logu. Helper lze nastavit tak, aby zálohu provedl pouze jednou za den.

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