<?php

namespace Minmax\Base\Middleware;

use Closure;
use Minmax\Base\Administrator\AdministratorMenuRepository;
use Minmax\Base\Administrator\WebDataRepository;
use Minmax\Base\Administrator\WorldLanguageRepository;

/**
 * Class SetAdministratorControllerAttributes
 */
class SetAdministratorControllerAttributes
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
        $uri = explode('/', preg_replace("/^\//", '', str_replace(app()->getLocale(), '', $request->path())))[1] ?? '';

        // 設定語系資料
        $languageData = (new WorldLanguageRepository)->getLanguageList();

        // 設定啟用語系資料
        $languageActive = (new WorldLanguageRepository)->getLanguageActive();

        // 設定 選單資料
        $systemMenu = (new AdministratorMenuRepository)->getMenu();

        // 設定 頁面資料
        $pageData = (new AdministratorMenuRepository)->one(['uri' => $uri]);

        // 設定 帳號資料
        $adminData = $request->user('administrator');

        $request->attributes->add([
            'controllerAttributes' => [
                'webData' => $webData,
                'uri' => $uri,
                'languageData' => $languageData,
                'languageActive' => $languageActive,
                'systemMenu' => $systemMenu,
                'pageData' => $pageData,
                'adminData' => $adminData,
            ]
        ]);

        return $next($request);
    }
}
