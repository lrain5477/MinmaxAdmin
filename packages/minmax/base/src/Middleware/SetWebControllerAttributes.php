<?php

namespace Minmax\Base\Middleware;

use Closure;
use Minmax\Base\Web\WebMenuRepository;
use Minmax\Base\Web\WebDataRepository;
use Minmax\Base\Web\WorldLanguageRepository;

/**
 * Class SetWebControllerAttributes
 */
class SetWebControllerAttributes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 設定 網站資料
        $webData = (new WebDataRepository)->getData() ?? abort(404);
        if (! $webData->active) abort(404, $webData->offline_text);

        // 設定 Uri
        $uri = explode('/', str_replace("/^\//", '', str_replace(app()->getLocale(), '', $request->path())))[0] ?? '';

        // 設定語系資料
        $languageData = (new WorldLanguageRepository)->getLanguageList();

        // 設定 選單資料
        $systemMenu = (new WebMenuRepository)->getMenu();

        // 設定 頁面資料
        $pageData = (new WebMenuRepository)->one(['uri' => $uri, 'active' => true]);

        $request->attributes->add([
            'controllerAttributes' => [
                'webData' => $webData,
                'uri' => $uri,
                'languageData' => $languageData,
                'systemMenu' => $systemMenu,
                'pageData' => $pageData,
            ]
        ]);

        return $next($request);
    }
}
