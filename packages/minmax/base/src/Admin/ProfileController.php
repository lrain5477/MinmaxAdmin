<?php

namespace Minmax\Base\Admin;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ProfileController
 */
class ProfileController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(AdminRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * @param  string $type
     * @return void
     */
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
            $breadcrumbs->push(__('MinmaxBase::admin.header.account'));
        });
    }

    protected function checkValidate()
    {
        app(ProfileRequest::class);
    }

    /**
     * Admin profile edit.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function edit($id = null)
    {
        return parent::edit($this->adminData->id);
    }

    /**
     * Admin profile update
     *
     * @param  Request $request
     * @param  null $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id = null)
    {
        $this->checkPermissionEdit();

        $this->checkValidate();

        $id = $this->adminData->id;

        $model = $this->modelRepository->find($id) ?? abort(404);

        $inputSet = $request->input('Admin');

        // 儲存更新資料
        try {
            \DB::beginTransaction();

            if ($this->modelRepository->save($model, $inputSet)) {
                \DB::commit();
                LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('MinmaxBase::admin.form.message.edit_success'));
                return redirect(langRoute("admin.profile"))->with('success', __('MinmaxBase::admin.form.message.edit_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('MinmaxBase::admin.form.message.edit_error'));
        return redirect(langRoute("admin.profile"))->withErrors([__('MinmaxBase::admin.form.message.edit_error')])->withInput();
    }
}
