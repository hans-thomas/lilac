<?php

namespace Hans\Lilac;

use Hans\Lilac\Services\LilacService;
use Illuminate\Support\ServiceProvider;

class LilacServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('lilac-service', LilacService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'lilac');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('lilac.php'),
            ], 'lilac-config');
        }
    }
}
