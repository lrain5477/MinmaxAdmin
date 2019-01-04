<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        //$this->mapApiRoutes();
        $this->mapWebRoutes();
        //$this->mapAdminRoutes();
        //$this->mapAdministratorRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::prefix(LaravelLocalization::setLocale())
            ->middleware(['web', 'localizationRedirect'])
            ->namespace($this->namespace . '\Web')
            ->name('web.' . app()->getLocale() . '.')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix(LaravelLocalization::setLocale())
            ->middleware(['admin', 'localizationRedirect'])
            ->namespace($this->namespace . '\Admin')
            ->name('admin.' . app()->getLocale() . '.')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "administrator" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdministratorRoutes()
    {
        Route::prefix(LaravelLocalization::setLocale())
            ->middleware(['administrator', 'localizationRedirect'])
            ->namespace($this->namespace . '\Administrator')
            ->name('administrator.' . app()->getLocale() . '.')
            ->group(base_path('routes/administrator.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace . '\Api')
             ->group(base_path('routes/api.php'));
    }
}
