<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy {--message=} {--branch=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy project changes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $git_commit_message = "";
        $branch = "";

        $choices = $this->choice(
            'What to deploy?',
            ['remove-ds-store', 'compile-assets', 'git-add-commit', 'git-push', 'trigger', 'all'],
            null,
            $maxAttempts = null,
            $allowMultipleSelections = true
        );

        // If the git commit message is needed, determine what it is.
        if(in_array("git-add-commit", $choices)
            || in_array("git-push", $choices)
            || in_array("all", $choices)
        ) {
            // Get the git commit message from command input first.
            $git_commit_message = $this->option('message');

            // If no git commit message was specified from the command input, then ask for it.
            if($git_commit_message === "" || $git_commit_message === null) {
                $default_git_commit_message = "Default git commit message";
                $git_commit_message = $this->ask('What shall the git commit message be?', $default_git_commit_message);
                if(! $git_commit_message || $git_commit_message === "") {
                    $git_commit_message = $default_git_commit_message;
                }
            }
        }

        // If the branch is needed, determine what it is.
        if(in_array("git-push", $choices)
            || in_array("trigger", $choices)
            || in_array("all", $choices)
        ) {
            // Get the branch from command input first.
            $branch = $this->option('branch');

            // If no branch was specified from the command input, then ask for it.
            if($branch === "" || $branch === null) {
                $branch = $this->choice(
                    'What branch to push to?',
                    ['develop', 'master'],
                    1
                );
            }
        }

        // If remove-ds-store option is selected...
        if(in_array("remove-ds-store", $choices)
            || in_array("all", $choices)
        ) {
            $this->call('deploy:remove-ds-store', [
                //
            ]);
        }

        // If compile-assets option is selected...
        if(in_array("compile-assets", $choices)
            || in_array("all", $choices)
        ) {
            $this->call('deploy:compile-assets', [
                //
            ]);
        }

        // If git-add-commit option is selected...
        if(in_array("git-add-commit", $choices)
            || in_array("all", $choices)
        ) {
            $this->call('deploy:git-add-commit', [
                '--commit_message' => $git_commit_message,
            ]);
        }

        // If git-push option is selected...
        if(in_array("git-push", $choices)
            || in_array("all", $choices)
        ) {
            $this->call('deploy:git-push', [
                '--branch' => $branch,
            ]);
        }

        // If trigger option is selected...
        if(in_array("trigger", $choices)
            || in_array("all", $choices)
        ) {
            $this->call('deploy:trigger', [
                '--environment' => $branch,
            ]);
        }

        $this->info(PHP_EOL . 'Finished deployment!');
        return 0;
    }
}
