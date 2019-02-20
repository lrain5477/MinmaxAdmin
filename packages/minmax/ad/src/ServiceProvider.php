<?php

namespace Minmax\Ad;

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
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/administrator.php');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/translations', 'MinmaxAd');
        $this->loadViewsFrom(__DIR__ . '/views', 'MinmaxAd');
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
