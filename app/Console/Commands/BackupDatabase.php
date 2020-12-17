<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--dropbox}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    private $available_backup_destinations = ['local', 'dropbox'];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $backup_destination = 'local';
        if($this->option('dropbox')) {
            $backup_destination = 'dropbox';
        }

        $filename = date("Y-m-d H-i-s e") . '.sql.gz';

        $process = Process::fromShellCommandline(sprintf(
            'mysqldump -u%s -p%s %s | gzip > "%s"',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            storage_path('app/db_backups/' . $filename)
        ));

        try {
            // Always create the backup locally first
            $process->mustRun();

            // The backup may also optionally be sent to Dropbox
            if($backup_destination === 'dropbox') {
                Storage::disk('dropbox')->putFileAs(config('app.name') . '/' . basename(config('app.url')), new File(storage_path('app/db_backups/' . $filename)), $filename);

                // Now that the backup is copied to dropbox, delete the local copy
                Storage::disk('local')->delete('db_backups/' . $filename);
            }

        } catch (ProcessFailedException $ex) {
            $this->error('The backup process has been failed.');
            $this->comment($ex->getMessage());
        }

        $this->info('The backup has been completed successfully!');
        $this->info('Backed up to: ' . $backup_destination);
        $this->info('Filename: ' . $filename);

        return 0;
    }
}
