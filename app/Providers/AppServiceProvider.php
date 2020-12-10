<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // List of whitelisted IP addresses to always run in debug mode
        if(in_array(get_ip_address(), [
            '98.224.99.239', // Nick (September 20, 2020)
        ])) {
            config(['app.debug' => true]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
