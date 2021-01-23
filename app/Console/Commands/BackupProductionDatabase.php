<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Storage;

class BackupProductionDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup-production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the production database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // This command is intended to only be run on development environments!

        try {
            // This is the command that needs to be executed:
            $command = "ssh forge@socrates php /home/forge/nicholas-morgan.com/current/artisan db:backup --dropbox";

            $process = Process::fromShellCommandline($command);
            $process->mustRun(function($type, $buffer) {
                if(Process::ERR === $type) {
                    $this->error($buffer);
                }
                else {
                    $this->comment($buffer);
                }
            });

            // TODO (later) - automatically set this DB to be the new development DB.

            return 0;
        }
        catch (ProcessFailedException $ex) {
            $this->error('The production database backup process has been failed.');
            $this->comment($ex->getMessage());

            return 1;
        }
    }


}
