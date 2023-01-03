<?php

namespace App\Providers;

use App\Activity;
use App\Observers\ActivityObserver;
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
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

        $this->app->singleton('valuestore', function () {
            return \Spatie\Valuestore\Valuestore::make(storage_path('app/settings.json'));
        });
        $values = $this->app->valuestore->all();
        $this->app->bind('settings', function () use ($values) {
            return $values;
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Activity::observe(ActivityObserver::class);
    }
}
