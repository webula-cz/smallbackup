<?php
if (!function_exists('wsb_backup_db')) {
    function wsb_backup_db(string $connectionName = null, bool $noCleanup = false): bool {
        try {
            $manager = new \Webula\SmallBackup\Classes\DbBackupManager;
            if (!$noCleanup) {
                $manager->clear();
            }
            $manager->backup($connectionName);
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return false;
        }
        return true;
    }
}

if (!function_exists('wsb_backup_theme')) {
    function wsb_backup_theme(string $themeName = null, bool $noCleanup = false): bool {
        try {
            $manager = new \Webula\SmallBackup\Classes\ThemeBackupManager;
            if (!$noCleanup) {
                $manager->clear();
            }
            $manager->backup($themeName);
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return false;
        }
        return true;
    }
}