<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;
use Artisan;

class DbRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-restore
        { --sourcePath= }
        { --source=dropbox }
        { --database=mysql }
        { --compression=gzip }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the database.';

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
        $sourcePath = (string) $this->option('sourcePath');
        $source = (string) $this->option('source');
        $database = (string) $this->option('database');
        $compression = (string) $this->option('compression');

        // If the specific source path was not specified, ask the user if they would like to use the latest one.
        if($sourcePath === '') {
            if($this->confirm('No sourcePath was specified. Use latest?')) {
                $fromEnvironment = $this->choice('What environment to restore from?', ['development', 'production'], 0);

                $sourcePath = config('app.name') . "/" . $fromEnvironment . "/latest.gz";
            }
            else {
                $this->comment('Okay. The restore will not be completed. See ya.');
                return;
            }
        }

        // Execute the command.
        $callCommand = "db:restore --source=$source --sourcePath='$sourcePath' --database=$database --compression=$compression";
        $this->comment('Restoring...');
        $this->comment('Command: <info>' . $callCommand . '</info>');
        Artisan::call($callCommand);
        $this->comment('Completed!');
        $this->comment('');

        $this->info('Restore Completed!');
    }
}
