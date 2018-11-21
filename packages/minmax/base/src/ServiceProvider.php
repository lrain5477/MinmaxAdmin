<?php

namespace Minmax\Base;

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
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include(__DIR__ . '/Helpers/ShortcutHelper.php');
    }
}
