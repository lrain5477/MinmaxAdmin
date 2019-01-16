<?php

namespace Minmax\Member;

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
        $this->loadRoutesFrom(__DIR__ . '/routes/administrator.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/translations', 'MinmaxMember');
        $this->loadViewsFrom(__DIR__ . '/views', 'MinmaxMember');
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
