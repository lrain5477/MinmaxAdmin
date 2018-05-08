<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminMenuClass;
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
    protected $pageData;
    protected $modelName;
    protected $modelRepository;

    public function __construct(ProfileRepository $modelRepository)
    {
        $this->middleware(function($request, $next) {
            $this->adminData = Auth::guard('admin')->user();
            $this->viewData['adminData'] = $this->adminData;
            $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'admin'])->first();

            return $next($request);
        });

        $this->uri = 'profile';
        $this->modelRepository = $modelRepository;

        $this->viewData['pageData'] = collect([[
            'uri' => $this->uri,
            'title' => __('admin.header.profile'),
            'parent' => '0',
        ]])->map(function($item, $key) { return (object) $item; })->first();

        $this->viewData['menuData'] = $this->getMenuData();
    }

    protected function getMenuData() {
        $menuItemData = AdminMenuClass::where(['active' => 1])->orderBy('sort')->get();

        return $menuItemData;
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
                return redirect()->route('admin.profile')->with('success', __('admin.form.message.edit_success'));
            }

            return redirect()->route('admin.profile')->withErrors([__('admin.form.message.edit_error')])->withInput();
        }

        return redirect()->route('admin.profile')->withErrors($validator)->withInput();
    }
}
