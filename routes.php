<?php
use Webula\SmallBackup\Models\Settings;

Route::get(config('webula.smallbackup::trigger.url_prefix') . '{trigger_key}', function (string $trigger_key) {
    if (Settings::get('has_trigger') && $trigger_key === Settings::get('trigger_key')) {
        if (Settings::get('db_mode') == 'trigger') {
            // wsb_backup_db();
            Artisan::call('smallbackup:db');
        }
        if (Settings::get('theme_mode') == 'trigger') {
            // wsb_backup_theme();
            Artisan::call('smallbackup:theme');
        }
        if (Settings::get('storage_mode') == 'trigger') {
            // wsb_backup_storage();
            Artisan::call('smallbackup:storage');
        }
        response()->noContent()->setStatusCode(200)->send();
    } else {
        abort(403);
    }
});