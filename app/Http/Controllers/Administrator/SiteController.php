<?php

namespace App\Http\Controllers\Administrator;

use Analytics;
use App\Models\WebData;
use App\Repositories\Administrator\Repository;
use Illuminate\Support\Carbon;
use Spatie\Analytics\Period;

class SiteController extends Controller
{
    public function __construct(Repository $modelRepository)
    {
        $this->middleware('auth:administrator');

        parent::__construct($modelRepository);

        $this->adminData = \Auth::guard('administrator')->user();
        $this->viewData['adminData'] = $this->adminData;
        $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'administrator'])->first();
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
