<?php

namespace Minmax\Base\Admin;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Minmax\Base\Helpers\Log as LogHelper;

class ProfileController extends Controller
{
    public function __construct(Request $request, AdminRepository $adminRepository)
    {
        $this->modelRepository = $adminRepository;

        parent::__construct($request);
    }

    protected function checkPermissionEdit($type = 'web') {}

    /**
     * @param  string|integer $id
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsEdit($id)
    {
        Breadcrumbs::register('edit', function ($breadcrumbs) use ($id) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push(__('admin.header.account'));
        });
    }

    protected function checkValidate()
    {
        app(ProfileRequest::class);
    }

    /**
     * Admin profile edit.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function edit($id = null)
    {
        return parent::edit($this->adminData->guid);
    }

    /**
     * Model Update
     *
     * @param string $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id = null, Request $request)
    {
        $this->checkPermissionEdit();

        $this->checkValidate();

        $model = $this->modelRepository->find($this->adminData->guid) ?? abort(404);

        $inputSet = $request->input('Admin');

        // 儲存更新資料
        try {
            \DB::beginTransaction();

            if ($this->modelRepository->save($model, $inputSet)) {
                \DB::commit();
                LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('admin.form.message.edit_success'));
                return redirect(langRoute("admin.profile"))->with('success', __('admin.form.message.edit_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('admin.form.message.edit_error'));
        return redirect(langRoute("admin.profile"))->withErrors([__('admin.form.message.edit_error')])->withInput();
    }
}
