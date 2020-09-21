<?php

namespace App\Providers;

use App\Models\Fixture;
use App\Observers\FixtureObserver;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fixture::observe(FixtureObserver::class);

    }
}
