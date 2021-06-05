<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;
use App\Console\Commands\DisplaysCommandOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RemoveDsStore extends Command
{
    use DisplaysCommandOutput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:remove-ds-store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove pesky .DS_Store hidden files from the entire project tree that might have been automatically created by macOS Finder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->comment(PHP_EOL . 'Removing pesky <info>`.DS_Store`</info> files...');
            $process = Process::fromShellCommandline('find ' . base_path() . ' -name ".DS_Store" -delete');
            $process->mustRun($this->mustRunOutput());
            $this->comment("All pesky <info>`.DS_Store`</info> files have been removed!");
            return 0;
        }
        catch(ProcessFailedException $ex) {
            $this->error('An exception occurred. ' . $ex->getMessage());
            return 10;
        }
    }

}
