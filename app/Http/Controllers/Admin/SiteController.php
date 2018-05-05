<?php

namespace App\Http\Controllers\Admin;

use Analytics;
use App\Models\WebData;
use Auth;
use App\Repositories\Admin\Repository;
use Illuminate\Support\Carbon;
use Spatie\Analytics\Period;

class SiteController extends Controller
{
    public function __construct(Repository $modelRepository)
    {
        $this->middleware('auth:admin');

        parent::__construct($modelRepository);

        $this->adminData = Auth::guard('admin')->user();
        $this->viewData['adminData'] = $this->adminData;
        $this->viewData['menuData'] = $this->getMenuData();
        $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'admin'])->first();
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

        return view('admin.site.index', $this->viewData);
    }
}
