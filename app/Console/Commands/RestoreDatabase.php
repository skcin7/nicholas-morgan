<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Storage;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {--dropbox}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $restore_from = '';

        if($this->option('dropbox')) {
            $restore_from = 'dropbox';
        }

        if($restore_from === "") {
            $restore_from = $this->anticipate('Where should the restore be from?', ['local', 'dropbox'], 'local');
        }

        if(! in_array($restore_from, ['local', 'dropbox'])) {
            $this->error('Invalid Restore From Location!');
            return 1;
        }

        switch($restore_from) {
            case 'local':
            default:
                $available_backup_files = Storage::disk('local')->allFiles('db_backups');
                break;
            case 'dropbox':
                $available_backup_files = Storage::disk('dropbox')->allFiles(config('app.name'));
                break;
        }

        // Remove any files that may have been found which are not backups, such as '.DS_Store'
        foreach($available_backup_files as $key => $available_backup_file) {
            if(strpos($available_backup_file,'.sql.gz') === false) {
                unset($available_backup_files[$key]);
            }
        }

        // Get the backup to be restored
        $backup_file_relative_path = $this->anticipate('What backup should be restored from?', $available_backup_files);

        // If the restore is being done from Dropbox, then the backup must first be copied temporarily to the local disk
        if($restore_from === 'dropbox') {
            Storage::disk('local')->put('db_backups/dropbox_tmp_restore.sql.gz', Storage::disk('dropbox')->get($backup_file_relative_path));

            // Now that the copy has been made locally, update what the relative path is
            $backup_file_relative_path = 'db_backups/dropbox_tmp_restore.sql.gz';
        }

        // Execute the restore
        try {
            $process = Process::fromShellCommandline(sprintf(
                'gunzip < %s | mysql -u%s -p%s %s',
                storage_path('app/db_backups/' . basename($backup_file_relative_path)),
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.database')
            ));

            $process->mustRun();
        } catch (ProcessFailedException $ex) {
            $this->error('The backup process has been failed.');
        }

        // If dropbox, then the temporary backup file must be deleted
        if($restore_from === 'dropbox') {
            Storage::disk('local')->delete('db_backups/dropbox_tmp_restore.sql.gz');
        }

        $this->info('The restore has been completed successfully!');
        $this->info('Restored from: ' . $restore_from);

        return 0;
    }
}
