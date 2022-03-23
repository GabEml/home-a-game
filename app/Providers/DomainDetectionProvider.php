<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DomainDetectionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
            config(
                [
                    'app.app_domain' => explode('.', $_SERVER['HTTP_HOST'])[0]
                ]
            );
        }
    }
}
