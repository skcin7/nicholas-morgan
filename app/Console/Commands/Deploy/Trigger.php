<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Console\Commands\DisplaysCommandOutput;

class Trigger extends Command
{
    use DisplaysCommandOutput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:trigger { --environment= }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger deployment to the specified environment';

    /**
     * The trigger URLs used for deployment to each environment
     *
     * @var string[]
     */
    private $trigger_urls = [
        'develop' => '',
        'master' => 'https://envoyer.io/deploy/tvp5o40TapdIQCZ7YiXLL4SnuL8E1StwR0ScYhIR',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $environment = $this->option('environment');

        // If the environment was not specified as an input option when calling the command, then prompt the user for input to
        // ask what environment to trigger the deployment to.
        if(! $environment) {
            $environment = $this->choice(
                'What environment to deploy to?',
                ['develop', 'master']
            );
        }

        try {
            $this->comment(PHP_EOL . 'Triggering the deployment to the <info>' . $environment . '</info> environment...');
            $process = Process::fromShellCommandline('curl -X POST ' . $this->trigger_urls[$environment]);
            $process->mustRun($this->mustRunOutput());
            $this->comment("Deployment successfully triggered to the <info>" . $environment . "</info> environment!" . PHP_EOL);
            return 0;
        }
        catch(ProcessFailedException $ex) {
            $this->error('An exception occurred. ' . $ex->getMessage());
            return 10;
        }
    }
}
