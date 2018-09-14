<?php

namespace App\Http\Middleware;

use App\Models\WorldLanguage;
use App\Repositories\Admin\WorldLanguageRepository;
use Cache;
use Closure;

class AdminLanguage
{
    protected $guard = 'admin';
    protected $prefix = 'siteadmin';

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
        if ($languageSet->where('code', $uriSet[1])->count() == 1) {
            app()->setLocale($uriSet[1]);
        } else {
            $uriSet[0] = app()->getLocale();
            return redirect($this->prefix . '/' . implode('/', $uriSet));
        }

        return $next($request);
    }
}
