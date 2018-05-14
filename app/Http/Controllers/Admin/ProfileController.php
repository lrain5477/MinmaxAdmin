<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Models\AdminMenuClass;
use App\Models\Language;
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

        $this->languageData = Language::all();
        $this->viewData['languageData'] = $this->languageData->where('active', '1');

        $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'admin', 'active' => 1])->first() ?? abort(404);

        $this->uri = 'profile';
        $this->modelRepository = $modelRepository;

        $this->pageData = $this->getPageData($this->uri);
        $this->viewData['pageData'] = $this->pageData;

        $this->viewData['menuData'] = $this->getMenuData();

        $this->middleware(function($request, $next) {
            $this->adminData = Auth::guard('admin')->user();
            $this->viewData['adminData'] = $this->adminData;

            if(\Request::has('language') && $this->languageData->where('codes', \Request::get('language'))->where('active', '1')->count() > 0) {
                session()->put('adminLanguage', \Request::get('language'));
                session()->save();
            }
            if(session()->has('adminLanguage') && !is_null(session('adminLanguage'))) {
                app()->setLocale(session('adminLanguage'));
            }

            return $next($request);
        });

        // 檢查經過前一個 middleware 後，是否需要重讀語系資料
        $this->middleware(function($request, $next) use ($modelRepository) {
            if(isset($this->viewData['webData']) && $this->viewData['webData']->lang !== app()->getLocale()) {
                $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'admin'])->first() ?? abort(404);
            }
            if($this->pageData && $this->pageData->lang !== app()->getLocale()) {
                $this->pageData = $this->getPageData($this->uri);
                $this->viewData['pageData'] = $this->pageData;

                if($this->pageData) {
                    $this->modelRepository = $modelRepository;
                } else {
                    abort(404);
                }
            }

            return $next($request);
        });
    }

    protected function getMenuData() {
        $menuItemData = AdminMenuClass::where(['active' => 1])->orderBy('sort')->get();

        return $menuItemData;
    }

    protected function getPageData($uri) {
        return collect([[
            'lang' => app()->getLocale(),
            'uri' => $uri,
            'title' => __('admin.header.profile'),
            'parent' => '0',
        ]])->map(function($item, $key) { return (object) $item; })->first();
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
