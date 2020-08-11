<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Http;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy
        {  deploymentUrl=https://envoyer.io/deploy/tvp5o40TapdIQCZ7YiXLL4SnuL8E1StwR0ScYhIR  }
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the application to production.';

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
        $deployment_url = $this->argument('deploymentUrl');
        $response = Http::post($deployment_url);
        $this->info('Envoyer deployment initiated.');
    }
}
