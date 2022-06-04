<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Storage;

class StorageSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the storage assets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Regardless of if the sync is from/to the server, the list of available directories is obtained locally
        $available_directories = Storage::disk('local')->allDirectories();
        $available_directories[] = '.';

        $directory_to_sync = $this->anticipate('What directory should be synced?', $available_directories);
        if(! in_array($directory_to_sync, $available_directories)) {
            $this->error($directory_to_sync . ' is not one of the available directories that can be synced!');
            return 1;
        }

        $available_sync_directions = ['local->production', 'production->local'];
        $sync_direction = $this->anticipate('Sync direction?', $available_sync_directions);
        if(! in_array($sync_direction, $available_sync_directions)) {
            $this->error($sync_direction . ' is not one of the valid sync directions!');
            return 1;
        }

        // The sync direction will determine what specific rsync command/input should be made
        switch($sync_direction) {
            case 'local->production':
                $rsync_command = 'rsync -chavzP --stats /Users/skcin7/www/nicholas-morgan/storage/app/%s/ forge@socrates2:/home/forge/nicholas-morgan.com/storage/app/%s/';
                break;
            case 'production->local':
                $rsync_command = 'rsync -chavzP --stats forge@socrates2:/home/forge/nicholas-morgan.com/storage/app/%s/ /Users/skcin7/www/nicholas-morgan/storage/app/%s/';
                break;
        }

        try {
            // to production
            $process = Process::fromShellCommandline(sprintf(
                $rsync_command,
                $directory_to_sync,
                $directory_to_sync
            ));

            $process->setTimeout(60 * 60 * 24);

            $process->mustRun(function($type, $buffer) {
                if(Process::ERR === $type) {
                    $this->error($buffer);
                }
                else {
                    $this->comment($buffer);
                }
            });

            $this->info('The sync has completed successfully!');
        } catch (ProcessFailedException $ex) {
            $this->error('The storage sync process has failed.');
        }

        return 0;
    }
}
