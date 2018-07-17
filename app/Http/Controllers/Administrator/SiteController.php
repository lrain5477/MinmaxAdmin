<?php

namespace App\Http\Controllers\Administrator;

use App\Models\GoogleAnalyticsClient;
use App\Repositories\Administrator\Repository;

class SiteController extends Controller
{
    protected $gaClient;

    public function __construct(Repository $modelRepository, GoogleAnalyticsClient $gaClient)
    {
        parent::__construct($modelRepository);

        $this->middleware(function($request, $next) use ($gaClient) {
            $this->gaClient = $gaClient;
            return $next($request);
        });
    }

    /**
     * Display Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 最新客服表單
        $this->viewData['contactData'] = collect([]);

        // 客服信函數量
        $this->viewData['contactAmount'] = 0;

        // Google Analytics
        $this->viewData['currentVisitor'] = $this->gaClient->getActiveVisitors();
        $this->viewData['pageViewsPerSession'] = $this->gaClient->getPageViewsPerSession();
        $this->viewData['avgTimeOnPage'] = $this->gaClient->getAvgTimeOnPage();
        $this->viewData['exitRate'] = $this->gaClient->getExitRate();
        $this->viewData['browserUsage'] = $this->gaClient->getTopBrowsers();
        $this->viewData['todayVisitor'] = $this->gaClient->getTodayTotalVisitors();
        $this->viewData['referrerKeyword'] = $this->gaClient->getReferrerKeyword();

        return view('administrator.site.index', $this->viewData);
    }
}
