<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SuperDeploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdeploy { --message=\"Super Deploy.\" }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Super deploy';

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
        try {
            $process = Process::fromShellCommandline('git add -A .');
            $process->mustRun($this->mustRunOutput());

            $process = Process::fromShellCommandline(sprintf(
                'git commit -m "%s"',
                $this->option('message'),
            ));
            $process->mustRun($this->mustRunOutput());

            $process = Process::fromShellCommandline('git push');
            $process->mustRun($this->mustRunOutput());

            $this->call('deploy');
            $this->info('The Super Deployment Has Completed!');

        } catch (ProcessFailedException $ex) {
            $this->error('The super deployment has failed.');
            $this->comment($ex->getMessage());
        }
    }

    /**
     * @return \Closure
     */
    private function mustRunOutput()
    {
        return function($type, $buffer) {
            if(Process::ERR === $type) {
                $this->error($buffer);
            }
            else {
                $this->comment($buffer);
            }
        };
    }
}
