<?php namespace Webula\SmallBackup\Console;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Webula\SmallBackup\Classes\DbBackupManager;
use Webula\SmallBackup\Models\Settings;

class Backup extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'smallbackup:backup';

    /**
     * @var string The console command description.
     */
    protected $description = 'Backup current database.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        if (!Settings::get('enabled')) {
            $this->output->write('Small backup is not enabled.');
            return;
        }

        $manager = new DbBackupManager;
        if (!$this->option('no-cleanup')) {
            try {
                $this->output->write('Cleanup...');
                $affected = $manager->clear();
                $this->output->success("'{$affected}' old backups were deleted!");
            } catch (Exception $ex) {
                $this->output->error("Cleanup failed! " . $ex->getMessage());
            }
        }

        try {
            $this->output->write('Backup...');
            $file = $manager->backup($this->argument('name'));
            $this->output->success("Backup was made successfully in file '{$file}'!");
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
            ['name', InputArgument::OPTIONAL, 'Database connection name.'],
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
