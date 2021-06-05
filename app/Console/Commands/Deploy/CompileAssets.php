<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;
use App\Console\Commands\DisplaysCommandOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CompileAssets extends Command
{
    use DisplaysCommandOutput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:compile-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile SCSS/JavaScript assets to be minified for production mode';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info(PHP_EOL . 'Minifying assets for production...');
            $process = Process::fromShellCommandline('npm run production');
            $process->mustRun($this->mustRunOutput());
            $this->info("Assets minified for production!");
            return 0;
        }
        catch(ProcessFailedException $ex) {
            $this->error('An exception occurred. ' . $ex->getMessage());
            return 10;
        }
    }
}
