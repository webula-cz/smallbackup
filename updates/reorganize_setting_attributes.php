<?php namespace Webula\SmallBackup\Updates;

use October\Rain\Database\Updates\Migration;
use Webula\SmallBackup\Models\Settings;
use Str;

/**
 *  Reorganize setting attributes
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Settings::set('db_mode', Settings::get('db_auto') ? 'schedule' : 'manual');
        Settings::set('theme_mode', Settings::get('theme_auto') ? 'schedule' : 'manual');
        Settings::set('storage_mode', Settings::get('storage_auto') ? 'schedule' : 'manual');
        Settings::set('trigger_key', 'trigger-' . (string) Str::uuid());
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Settings::set('db_auto', Settings::get('db_mode') == 'schedule');
        Settings::set('theme_auto', Settings::get('theme_mode') == 'schedule');
        Settings::set('storage_auto', Settings::get('storage_mode') == 'schedule');
    }
};
