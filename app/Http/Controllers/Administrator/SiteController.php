<?php

namespace App\Http\Controllers\Administrator;

use Analytics;
use App\Repositories\System\AdminMenuRepository;
use App\Repositories\System\ContactRepository;
use Illuminate\Support\Carbon;
use Spatie\Analytics\Period;

class SiteController extends Controller
{
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
        $this->viewData['currentVisitor'] = '-';
        $this->viewData['pageViewsPerSession'] = '-';
        $this->viewData['avgTimeOnPage'] = '--:--:--';
        $this->viewData['exitRate'] = '-';
        $this->viewData['browserUsage'] = [];
        $this->viewData['todayVisitor'] = '-';
        $this->viewData['referrerKeyword'] = [];

        return view('administrator.site.index', $this->viewData);
    }
}
