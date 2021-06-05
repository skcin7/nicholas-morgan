<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;
use App\Console\Commands\DisplaysCommandOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GitAddCommit extends Command
{
    use DisplaysCommandOutput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:git-add-commit {--commit_message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add and commit the current changes to the local git repository';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info(PHP_EOL . 'Adding and committing changes to local git repository...');

            // Determine what the commit message is to be used from the command input. If none is specified, then
            // prompt the user for the git commit message. If still no commit message is specified, then default
            // to a generic one.
            $commit_message = $this->option('commit_message');
            if(! $commit_message) {
                $commit_message = $this->ask('What shall the git commit message be?', 'Committing changes');
                if(! $commit_message || $commit_message === "") {
                    $commit_message = "Committing changes";
                }
            }

//            dd(sprintf(
//                'git commit -m "%s"',
//                $commit_message
//            ));

            // First add all changed files to the stage
            $process = Process::fromShellCommandline('git add -A .');
            $process->mustRun($this->mustRunOutput());

//            // Now commit files on the stage to the local git repository
            $process = Process::fromShellCommandline(sprintf(
                'git commit -m "%s"',
                $commit_message
            ));
//            $git_commit_command = addslashes('git commit -m ' . $commit_message);
            //dd($git_commit_command);
//            $process = Process::fromShellCommandline('git commit -m "hi"');
            $process->mustRun($this->mustRunOutput());

            $this->info("Added and committed changes to the local git reposotory!");
            return 0;
        }
        catch(ProcessFailedException $ex) {
            $this->error('An exception occurred. ' . $ex->getMessage());
            return 10;
        }
    }
}
