<?php namespace Webula\SmallBackup\Console;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Webula\SmallBackup\Classes\DbBackupManager;

class BackupDb extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'smallbackup:db';

    /**
     * @var string The console command description.
     */
    protected $description = 'Backup current or default database.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $manager = new DbBackupManager;
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

        try {
            $this->output->write('Backup...');
            $file = $manager->backup($this->argument('name'));
            $this->output->success(
                trans('webula.smallbackup::lang.backup.flash.successfull_backup', ['file' => $file])
            );
        } catch (Exception $ex) {
            $this->output->error("Backup failed! " . $ex->getMessage());
        }

        $this->output->write('Done.');

    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'Another database connection name.'],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['no-cleanup', 'nocleanup', InputOption::VALUE_NONE, 'Do not clean up old backups.', null],
        ];
    }
}
