<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        // if (env("APP_DEBUG"))
        // {
        // DB::listen(function ($query) {
        // echo("DB: " . $query->sql . "[". implode(",",$query->bindings). "]\n");
        // });
        // }

        if(env('NEW_PROJECT_PROBLEM') == true) {
            Schema::defaultStringLength(191);
        }
    }
}
