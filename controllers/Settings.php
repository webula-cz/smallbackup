<?php namespace Webula\SmallBackup\Controllers;

use Flash;
use File;
use Backend;
use Exception;
use Log;
use Request, Response, Redirect;
use System\Controllers\Settings as SystemSettings;
use Webula\SmallBackup\Classes\{DbBackupManager, ThemeBackupManager, StorageBackupManager};

class Settings extends SystemSettings
{
    //
    // OVERRIDE
    //

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

    /**
     * List of db backups
     *
     * @return array
     */
    public function getDbBackupList(): array
    {
        return (new DbBackupManager)->list();
    }

    /**
     * List of theme backups
     *
     * @return array
     */
    public function getThemeBackupList(): array
    {
        return (new ThemeBackupManager)->list();
    }

    /**
     * List of storage backups
     *
     * @return array
     */
    public function getStorageBackupList(): array
    {
        return (new StorageBackupManager)->list();
    }

    /**
     * Response downloaded file
     *
     * @param string $pathname
     * @return mixed
     */
    public function download($pathname)
    {
        $pathname = base_path(base64_decode($pathname));
        if (File::exists($pathname)) {
            return Response::file($pathname);
        }
        return Response::make('File not found!', 404);
    }

    /**
     * onBackup event
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_onBackup()
    {
        try {
            $manager = new DbBackupManager;
            $deleted = $manager->clear();
            $files[] = $manager->backup();

            $manager = new ThemeBackupManager;
            $deleted += $manager->clear();
            $files[] = $manager->backup();

            $manager = new StorageBackupManager;
            $deleted += $manager->clear();
            $files[] = $manager->backup();

            Flash::success(trans('webula.smallbackup::lang.backup.flash.backup_all', ['deleted' => $deleted, 'files' => implode(', ', $files)]));
            return Redirect::refresh();

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Flash::error($ex->getMessage());
        }
    }

    /**
     * onBackup database event
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_onBackupDb()
    {
        try {
            $manager = new DbBackupManager;
            $deleted = $manager->clear();
            $files[] = $manager->backup();

            Flash::success(trans('webula.smallbackup::lang.backup.flash.backup_all', ['deleted' => $deleted, 'files' => implode(', ', $files)]));
            return \Backend::redirect('webula/smallbackup/settings/update');
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            Flash::error($ex->getMessage());
        }
    }

    /**
     * onBackup theme event
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_onBackupTheme()
    {
        try {
            $manager = new ThemeBackupManager;
            $deleted = $manager->clear();
            $files[] = $manager->backup();

            Flash::success(trans('webula.smallbackup::lang.backup.flash.backup_all', ['deleted' => $deleted, 'files' => implode(', ', $files)]));
            return \Backend::redirect('webula/smallbackup/settings/update');
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            Flash::error($ex->getMessage());
        }
    }

    /**
     * onBackup storage event
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_onBackupStorage()
    {
        try {
            $manager = new StorageBackupManager;
            $deleted = $manager->clear();
            $files[] = $manager->backup();

            Flash::success(trans('webula.smallbackup::lang.backup.flash.backup_all', ['deleted' => $deleted, 'files' => implode(', ', $files)]));
            return \Backend::redirect('webula/smallbackup/settings/update');
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            Flash::error($ex->getMessage());
        }
    }

    /**
     * Get settings segment from URI
     *
     * @return array
     */
    private function getSegmentsFromRequest(): array
    {
        $segments = explode('/', trim(str_after(Request::getUri(), Backend::url()), '/'));
        return array_pad($segments, 3, null);
    }

}