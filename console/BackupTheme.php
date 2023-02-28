<?php namespace Webula\SmallBackup\Console;

use Exception;
use Webula\SmallBackup\Classes\Console\BackupCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Webula\SmallBackup\Classes\ThemeBackupManager;

class BackupTheme extends BackupCommand
{
    /**
     * @var string The console command name.
     */
    protected $name = 'smallbackup:theme';

    /**
     * @var string The console command description.
     */
    protected $description = 'Backup current or default theme.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $manager = new ThemeBackupManager();

        $this->cleanup($manager);

        try {
            $this->output->write('Backup...');
            $file = $manager->backup($this->argument('name'), boolval($this->option('once')));
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
            ['name', InputArgument::OPTIONAL, 'Another theme name.'],
        ];
    }
}
