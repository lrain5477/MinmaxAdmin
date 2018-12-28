<?php

namespace Minmax\Base;

use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use Illuminate\Support\Facades\DB;
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
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/translations', 'MinmaxBase');
        $this->loadViewsFrom(__DIR__.'/views', 'MinmaxBase');
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
}
