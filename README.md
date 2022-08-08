# smallbackup-plugin
Default folder: `storage/app/uploads/protected/backup`

## Artisan stránka
Spuštění služby:
```title = "artisan"
url = "/artisan/schedule"
is_hidden = 0
==
<?php
    function onStart()
    {
        if (\Webula\SmallBackup\Models\Settings::get('enabled')) {
            $manager = new \Webula\SmallBackup\Classes\DbBackupManager;
            try {
                $this['result1'] = $manager->clear();
            } catch (Exception $ex) {
                \Log::error("Cleanup failed! " . $ex->getMessage());
            }

            try {
                $this['result2'] = $manager->backup();
            } catch (Exception $ex) {
                \Log::error("Backup failed! " . $ex->getMessage());
            }
        }
    }
?>
==
Smazané zálohy: {{ result1 }}<br />
Soubor s novou zálohou: {{ result2 }}
```

## Console command
`php artisan smallbackup:backup [connectionName] [--no-cleanup]`
