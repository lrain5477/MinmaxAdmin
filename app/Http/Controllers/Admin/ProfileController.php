<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Models\AdminMenu;
use App\Models\WorldLanguage;
use App\Models\WebData;
use App\Repositories\Admin\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Breadcrumbs;
use Validator;

/**
 * Class ProfileController
 * @property \App\Models\Admin $adminData
 */
class ProfileController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $uri;
    protected $viewData;
    protected $adminData;
    protected $languageData;
    protected $pageData;
    protected $modelName;
    protected $modelRepository;

    public function __construct(ProfileRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;

        $this->middleware(function($request, $next) {
            /**
             * @var \Illuminate\Http\Request $request
             */

            // 取得 語系資料
            $this->languageData = WorldLanguage::all();
            $this->viewData['languageData'] = $this->languageData->where('active', '1');

            // 設定 語系
            if($request->has('language') && $this->languageData->where('codes', $request->get('language'))->where('active', '1')->count() > 0) {
                session(['adminLanguage' => $request->get('language')]);
                session()->save();
            }
            if(session()->has('adminLanguage') && !is_null(session('adminLanguage'))) {
                app()->setLocale(session('adminLanguage'));
            }

            $this->uri = 'profile';

            // 設定 網站資料
            $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'admin', 'active' => 1])->first() ?? abort(404);

            // 設定 選單資料
            $this->viewData['menuData'] = AdminMenu::where(['active' => 1])->orderBy('sort')->get();

            // 設定 頁面資料
            $this->pageData =  collect([[
                'lang' => app()->getLocale(),
                'uri' => $this->uri,
                'title' => __('admin.header.profile'),
                'parent' => '0',
            ]])->map(function($item) { return (object) $item; })->first();
            $this->viewData['pageData'] = $this->pageData;

            // 設定 帳號資料
            $this->adminData = Auth::guard('admin')->user();
            $this->viewData['adminData'] = $this->adminData;

            return $next($request);
        });
    }

    /**
     * Administrator profile edit.
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function edit()
    {
        $this->viewData['formData'] = $this->modelRepository->one(['guid' => $this->adminData->guid]);

        // 設定麵包屑導航
        Breadcrumbs::register('edit', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push(__('admin.header.account'));
        });

        return view('admin.' . $this->uri . '.edit', $this->viewData);
    }

    /**
     * Model Update
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->input('Admin'), [
            'name' => 'required',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $input = $request->input('Admin');
        if(is_null($input['password']) || $input['password'] === '') {
            unset($input['password']);
        } else {
            $input['password'] = \Hash::make($input['password']);
        }
        unset($input['password_confirmation']);

        if($validator->passes()) {
            if($this->modelRepository->save($input, ['guid' => $this->adminData->guid])) {
                LogHelper::system('admin', $this->uri, 'update', $this->adminData->guid, $this->adminData->username, 1, __('admin.form.message.edit_success'));
                return redirect()->route('admin.profile')->with('success', __('admin.form.message.edit_success'));
            }

            LogHelper::system('admin', $this->uri, 'update', $this->adminData->guid, $this->adminData->username, 0, __('admin.form.message.edit_error'));
            return redirect()->route('admin.profile')->withErrors([__('admin.form.message.edit_error')])->withInput();
        }

        LogHelper::system('admin', $this->uri, 'update', $this->adminData->guid, $this->adminData->username, 0, $validator->errors()->first());
        return redirect()->route('admin.profile')->withErrors($validator)->withInput();
    }
}
