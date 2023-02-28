<?php namespace Webula\SmallBackup\Classes\Console;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Webula\SmallBackup\Classes\BackupManager;

abstract class BackupCommand extends Command
{
    /**
     * Cleanup.
     * @return void
     */
    protected function cleanup(BackupManager $manager)
    {
        if (!$this->option('no-cleanup')) {
            try {
                $this->output->write('Cleanup...');
                $deleted = $manager->clear();
                $this->output->success(
                    trans('webula.smallbackup::lang.backup.flash.expired_deleted', ['deleted' => $deleted])
                );
            } catch (Exception $ex) {
                $this->output->error("Cleanup failed! " . $ex->getMessage());
            }
        }
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['once', null, InputOption::VALUE_NONE, 'Do not overwrite existing backup file.', null],
            ['no-cleanup', 'nocleanup', InputOption::VALUE_NONE, 'Do not clean up old backups.', null],
        ];
    }
}
