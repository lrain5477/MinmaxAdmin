<?php

namespace Minmax\World;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/translations', 'MinmaxWorld');
        $this->loadViewsFrom(__DIR__.'/views', 'MinmaxWorld');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
