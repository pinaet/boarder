<?php

namespace App\Providers;

use Inertia\Inertia;
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
        Inertia::share( [
            'app' => [
                'name' => config('app.name'),
                'url' => config('app.url'),
                'mis' => env('MIS_NAME')
            ],
        ]);
        // I'm using config, but your could use env

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
