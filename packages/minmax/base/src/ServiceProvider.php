<?php

namespace Minmax\Base;

use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Minmax\Base\Console\MinmaxControllerCommand;
use Minmax\Base\Console\MinmaxGeneratorCommand;
use Minmax\Base\Console\MinmaxModelCommand;
use Minmax\Base\Console\MinmaxPresenterCommand;
use Minmax\Base\Console\MinmaxRepositoryCommand;
use Minmax\Base\Console\MinmaxRequestCommand;
use Minmax\Base\Console\MinmaxTransformerCommand;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

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
        $this->loadTranslationsFrom(__DIR__ . '/translations', 'MinmaxBase');
        $this->loadViewsFrom(__DIR__ . '/views', 'MinmaxBase');
        $this->loadBreadcrumbs();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelper();

        $this->registerRouteLocalization();

        $this->registerCommands();

    }

    protected function registerHelper()
    {
        include(__DIR__ . '/Helpers/ShortcutHelper.php');
    }

    protected function registerRouteLocalization()
    {
        $defaultLocale = config('app.locale');

        $pathUriSet = explode('/', request()->path());

        if (in_array('administrator', $pathUriSet)) {
            try {
                if ($webData = DB::table('web_data')->where('guard', 'administrator')->first()) {
                    $defaultLocale = $webData->system_language;
                }
            } catch (\Exception $e) {}
        }

        if (in_array('siteadmin', $pathUriSet)) {
            try {
                if ($webData = DB::table('web_data')->where('guard', 'admin')->first()) {
                    $defaultLocale = $webData->system_language;
                }
            } catch (\Exception $e) {}
        }

        try {
            $languageSet = DB::table('world_language')
                ->where('active', true)
                ->orderBy('sort')
                ->get()
                ->sortBy(function ($item) use ($defaultLocale) {
                    return $item->code == $defaultLocale ? 0 : $item->sort;
                })
                ->mapWithKeys(function ($item) {
                    return [
                        $item->code => [
                            'name' => $item->name,
                            'script' => json_decode($item->options, true)['script'] ?? '',
                            'native' => $item->native
                        ]
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            $languageSet = [
                'zh-Hant' => ['name' => '繁體中文', 'script' => 'Hant', 'native' => '繁體中文']
            ];
        }

        config([
            'laravellocalization.supportedLocales' => $languageSet,

            'laravellocalization.useAcceptLanguageHeader' => true,

            'laravellocalization.hideDefaultLocaleInURL' => ! config('app.locale_uri'),
        ]);
    }

    protected function loadBreadcrumbs()
    {
        $breadcrumbs = $this->app->make(BreadcrumbsManager::class);

        require (__DIR__ . '/breadcrumbs/administrator.php');
        require (__DIR__ . '/breadcrumbs/admin.php');
    }

    protected function registerCommands()
    {
        $this->app->singleton('command.minmax.generator', function () {
            return new MinmaxGeneratorCommand();
        });

        $this->app->singleton('command.minmax.model', function ($app) {
            return new MinmaxModelCommand($app['files']);
        });

        $this->app->singleton('command.minmax.repository', function ($app) {
            return new MinmaxRepositoryCommand($app['files']);
        });

        $this->app->singleton('command.minmax.controller', function ($app) {
            return new MinmaxControllerCommand($app['files']);
        });

        $this->app->singleton('command.minmax.request', function ($app) {
            return new MinmaxRequestCommand($app['files']);
        });

        $this->app->singleton('command.minmax.presenter', function ($app) {
            return new MinmaxPresenterCommand($app['files']);
        });

        $this->app->singleton('command.minmax.transformer', function ($app) {
            return new MinmaxTransformerCommand($app['files']);
        });

        $this->commands(
            'command.minmax.generator',
            'command.minmax.model',
            'command.minmax.repository',
            'command.minmax.controller',
            'command.minmax.request',
            'command.minmax.presenter',
            'command.minmax.transformer'
        );
    }
}
