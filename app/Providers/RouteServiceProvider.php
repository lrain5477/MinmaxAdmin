<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
        $languageMap = \Cache::rememberForever('langId', function() {
            try {
                $langTable = \DB::table('world_language')
                    ->where('active', '1')
                    ->orderBy('sort')
                    ->select(['id', 'code'])
                    ->get();
                return $langTable
                    ->mapWithKeys(function ($item) { return [$item->code => $item->id]; })
                    ->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });

        if (count($languageMap) < 2) {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
            $this->mapAdminRoutes();
            $this->mapAdministratorRoutes();
        } else {
            foreach ($languageMap as $langCode => $langId) {
                $this->mapApiRoutes($langCode);
                $this->mapWebRoutes($langCode);
                $this->mapAdminRoutes($langCode);
                $this->mapAdministratorRoutes($langCode);
            }
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  string $langPrefix
     * @return void
     */
    protected function mapWebRoutes($langPrefix = null)
    {
        if ($langPrefix) {
            Route::prefix($langPrefix)
                ->middleware('web')
                ->name("{$langPrefix}.")
                ->namespace($this->namespace . '\Web')
                ->group(base_path('routes/web.php'));
        } else {
            Route::middleware('web')
                ->namespace($this->namespace . '\Web')
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  string $langPrefix
     * @return void
     */
    protected function mapAdminRoutes($langPrefix = null)
    {
        Route::prefix('siteadmin' . (is_null($langPrefix) ? '' : "/{$langPrefix}"))
            ->middleware('admin')
            ->name('admin.' . (is_null($langPrefix) ? '' : "{$langPrefix}."))
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "administrator" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  string $langPrefix
     * @return void
     */
    protected function mapAdministratorRoutes($langPrefix = null)
    {
        Route::prefix('administrator' . (is_null($langPrefix) ? '' : "/{$langPrefix}"))
            ->middleware('administrator')
            ->name('administrator.' . (is_null($langPrefix) ? '' : "{$langPrefix}."))
            ->namespace($this->namespace . '\Administrator')
            ->group(base_path('routes/administrator.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @param  string $langPrefix
     * @return void
     */
    protected function mapApiRoutes($langPrefix = null)
    {
        Route::prefix('api' . (is_null($langPrefix) ? '' : "/{$langPrefix}"))
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
