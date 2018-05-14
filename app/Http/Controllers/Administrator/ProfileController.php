<?php

namespace App\Http\Controllers\Administrator;

use App\Models\WebData;
use App\Repositories\Administrator\ProfileRepository;
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
        $this->modelRepository = $modelRepository;

        $this->middleware(function($request, $next) {
            /**
             * @var \Illuminate\Http\Request $request
             */

            $this->uri = 'profile';

            // 設定 網站資料
            $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'administrator'])->first();

            // 設定 頁面資料
            $this->viewData['pageData'] = collect([[
                'lang' => app()->getLocale(),
                'uri' => $this->uri,
                'title' => __('administrator.header.profile'),
                'parent' => '0',
            ]])->map(function($item, $key) { return (object) $item; })->first();

            // 設定 帳號資料
            $this->adminData = Auth::guard('administrator')->user();
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
            $breadcrumbs->parent('administrator.home');
            $breadcrumbs->push(__('administrator.header.account'));
        });

        return view('administrator.' . $this->uri . '.edit', $this->viewData);
    }

    /**
     * Model Update
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->input('Administrator'), [
            'name' => 'required',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $input = $request->input('Administrator');
        if(is_null($input['password']) || $input['password'] === '') {
            unset($input['password']);
        } else {
            $input['password'] = \Hash::make($input['password']);
        }
        unset($input['password_confirmation']);

        if($validator->passes()) {
            if($this->modelRepository->save($input, ['guid' => $this->adminData->guid])) {
                return redirect()->route('administrator.profile')->with('success', __('administrator.form.message.edit_success'));
            }

            return redirect()->route('administrator.profile')->withErrors([__('administrator.form.message.edit_error')])->withInput();
        }

        return redirect()->route('administrator.profile')->withErrors($validator)->withInput();
    }
}
