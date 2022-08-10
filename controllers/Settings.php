<?php namespace Webula\SmallBackup\Controllers;

use Lang;
use Flash;
use File;
use Backend;
use Exception;
use Request, Response, Redirect;
use System\Controllers\Settings as SystemSettings;
use Webula\SmallBackup\Classes\{DbBackupManager, ThemeBackupManager};

class Settings extends SystemSettings
{

    public function update($author = null, $plugin = null, $code = null)
    {
        $this->addViewPath(base_path('modules/system/controllers/settings'));
        return parent::update(...$this->getSegmentsFromRequest());
    }


    public function update_onSave($author = null, $plugin = null, $code = null)
    {
        return parent::update_onSave(...$this->getSegmentsFromRequest());
    }


    public function update_onResetDefault($author = null, $plugin = null, $code = null)
    {
        return parent::update_onResetDefault(...$this->getSegmentsFromRequest());
    }


    public function getDbBackupList(): array
    {
        return (new DbBackupManager)->list();
    }


    public function getThemeBackupList(): array
    {
        return (new ThemeBackupManager)->list();
    }


    public function download($pathname)
    {
        $pathname = base_path(base64_decode($pathname));
        if (File::exists($pathname)) {
            return Response::file($pathname);
        }
        return Response::make('File not found!', 404);
    }


    public function update_onBackup()
    {
        try {
            $manager = new DbBackupManager;
            $deleted = $manager->clear();
            $filename[] = $manager->backup();

            $manager = new ThemeBackupManager;
            $deleted += $manager->clear();
            $filename[] = $manager->backup();

            Flash::success(trans('webula.smallbackup::lang.backup.flash.cleanup_and_backup', ['deleted' => $deleted, 'file' => implode(', ', $filename)]));
            return Redirect::refresh();
        } catch (Exception $ex) {
            Flash::error($ex->getMessage());
        }
    }


    private function getSegmentsFromRequest(): array
    {
        $segments = explode('/', trim(str_after(Request::getUri(), Backend::url()), '/'));
        return array_pad($segments, 3, null);
    }

}