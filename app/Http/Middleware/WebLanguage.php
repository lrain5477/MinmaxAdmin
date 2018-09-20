<?php

namespace App\Http\Middleware;

use App\Models\WorldLanguage;
use App\Repositories\Admin\WorldLanguageRepository;
use Cache;
use Closure;

class WebLanguage
{
    protected $guard = 'web';
    protected $prefix = '';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $languageSet */
        $languageSet = Cache::rememberForever('languageSet', function() {
            return (new WorldLanguageRepository)
                ->all(function($query) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    $query->where('active', '1')->orderBy('sort');
                });
        });

        if ($languageSet->count() < 2) {
            if ($language = $languageSet->first()) {
                /** @var WorldLanguage $language */
                app()->setLocale($language->code);
            }
            return $next($request);
        }

        $uriSet = explode('/', $request->path());
        if (isset($uriSet[0]) && $languageSet->where('code', $uriSet[0])->count() == 1) {
            app()->setLocale($uriSet[0]);
        } else {
            return redirect(app()->getLocale() . '/' . $request->path());
        }

        return $next($request);
    }
}
