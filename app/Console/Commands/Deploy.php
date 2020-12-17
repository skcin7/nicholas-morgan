<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy {--trigger_url=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the application to production.';

    /**
     * The URL to hit to trigger the deployment.
     *
     * @var string
     */
    private $trigger_url = "https://envoyer.io/deploy/tvp5o40TapdIQCZ7YiXLL4SnuL8E1StwR0ScYhIR";

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
        $trigger_url = $this->trigger_url;

        if($this->option('trigger_url')) {
            $trigger_url = $this->option('trigger_url');
        }

        $client = new \GuzzleHttp\Client();
        $client->post($trigger_url);

        $this->info('Deployment Was Initiated!');
    }
}
