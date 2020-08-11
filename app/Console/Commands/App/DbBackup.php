<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;
use Artisan;
use Storage;

class DbBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-backup
        { --database=mysql }
        { --destination=dropbox }
        { --timestamp }
        { --compression=gzip }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get necessary input.
        $filenameWithoutTheExtension = date("d-m-Y H-i-s e");
        $filePath = config('app.name') . "/" . config('app.env');
        $destinationPath = $filePath . '/' . $filenameWithoutTheExtension;
        $database = $this->option('database');
        $destination = $this->option('destination');
        $timestamp = $this->option('timestamp');
        $compression = $this->option('compression');

        // Execute the command.
        $callCommand = "db:backup --database=$database --destination=$destination --destinationPath='$destinationPath' --timestamp=$timestamp --compression=$compression";
        $this->comment('Backing Up...');
        $this->comment('Command: <info>' . $callCommand . '</info>');
        Artisan::call($callCommand);
        $this->comment('Completed!');
        $this->comment('');

        // Sleep for a few seconds to give some time for the file to be transferred to the disk.
        $this->comment('Sleeping...');
        sleep(2);
        $this->comment('Completed!');
        $this->comment('');

        // Copy just made backup as latest.gz too.
        // TODO fix this - the timestamps are off due to when the timestamp date() being evaluated being different by a few seconds - so currently, latest.gz is never made.
        $this->comment('Copying to <info>latest.gz</info>...');
        if(Storage::disk('dropbox')->exists($filePath . '/latest.gz')) {
            Storage::disk('dropbox')->delete($filePath . '/latest.gz');
        }
        if(Storage::disk('dropbox')->exists($destinationPath . '.gz')) {
            Storage::disk('dropbox')->copy($destinationPath . '.gz', $filePath . '/latest.gz');
        }
        $this->comment('Completed!');
        $this->comment('');

        $this->info('Backup Completed!');
    }
}
