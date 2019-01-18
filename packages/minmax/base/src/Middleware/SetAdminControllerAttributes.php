<?php

namespace Minmax\Base\Middleware;

use Closure;
use Minmax\Base\Admin\AdminMenuRepository;
use Minmax\Base\Admin\WebDataRepository;
use Minmax\Base\Admin\WorldLanguageRepository;

/**
 * Class SetAdminControllerAttributes
 */
class SetAdminControllerAttributes
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
        $uri = explode('/', preg_replace("/^\//i", '', str_replace(app()->getLocale(), '', $request->path())))[1] ?? '';

        // 設定語系資料
        $languageData = (new WorldLanguageRepository)->getLanguageList();

        // 設定啟用語系資料
        $languageActive = (new WorldLanguageRepository)->getLanguageActive();

        // 設定 選單資料
        $systemMenu = (new AdminMenuRepository)->getMenu();

        // 設定 頁面資料
        $pageData = (new AdminMenuRepository)->one(['uri' => $uri, 'active' => true]);

        // 設定 帳號資料
        $adminData = $request->user('admin');

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
