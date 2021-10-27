<?php

namespace App\Providers;

use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        // if (env("APP_DEBUG"))
        // {
        // DB::listen(function ($query) {
        // echo("DB: " . $query->sql . "[". implode(",",$query->bindings). "]\n");
        // });
        // }
        Schema::defaultStringLength(191);
    }
}
