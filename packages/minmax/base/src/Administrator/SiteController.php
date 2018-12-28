<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\GoogleAnalyticsClient;

/**
 * Class SiteController
 */
class SiteController extends Controller
{
    protected $gaClient;

    public function __construct(GoogleAnalyticsClient $gaClient)
    {
        $this->gaClient = $gaClient;

        parent::__construct();
    }

    /**
     * Display Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        // 最新客服表單
//        $this->viewData['contactData'] = collect([]);
//
//        // 客服信函數量
//        $this->viewData['contactAmount'] = 0;
//
//        // Google Analytics
//        $this->viewData['currentVisitor'] = $this->gaClient->getActiveVisitors();
//        $this->viewData['percentNewSessions'] = $this->gaClient->getPercentNewSessions();
//        $this->viewData['pageViewsPerSession'] = $this->gaClient->getPageViewsPerSession();
//        $this->viewData['avgTimeOnPage'] = $this->gaClient->getAvgTimeOnPage();
//        $this->viewData['exitRate'] = $this->gaClient->getExitRate();
//        $this->viewData['browserUsage'] = $this->gaClient->getTopBrowsers();
//        $this->viewData['todayVisitor'] = $this->gaClient->getTodayTotalVisitors();
//        $this->viewData['referrerKeyword'] = $this->gaClient->getReferrerKeyword();
//        $this->viewData['sourceMedium'] = $this->gaClient->getSourceMedium();
//
//        // Google Analytics put into JSON file
//        $this->gaClient->putSourceMedium();     // 流量來源
//        $this->gaClient->putWeekSourceMedium(); // 一周流量來源
//        $this->gaClient->putSourceCountry();    // 流量國家來源

        return view('MinmaxBase::administrator.site.index', $this->viewData);
    }
}
