<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;
use App\Console\Commands\DisplaysCommandOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GitPush extends Command
{
    use DisplaysCommandOutput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:git-push {--branch=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push the current commit to the remote origin git repository';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Determine what the branch is to push the commit to. If none is specified, then ask the user for input.
        $branch = $this->option('branch');
        if(! $branch) {
            $branch = $this->choice(
                'What branch to push to?',
                ['develop', 'master'],
                0
            );
        }

        // Push changes to the remote git repository
        try {
            $this->comment(PHP_EOL . 'Pushing to the <info>' . $branch . '</info> branch...');
            $process = Process::fromShellCommandline('git push -u origin ' . $branch);
            $process->mustRun($this->mustRunOutput());
            $this->comment('Pushed to the <info>' . $branch . '</info> branch!');
            return 0;
        }
        catch(ProcessFailedException $ex) {
            $this->error('An exception occurred. ' . $ex->getMessage());
            return 10;
        }
    }
}
