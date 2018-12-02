<?php

namespace Minmax\Base\Admin;

use Illuminate\Http\Request;
use Minmax\Base\Helpers\Log as LogHelper;
use Minmax\Base\Models\Permission;

class RoleController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(RoleRepository $roleRepository)
    {
        $this->modelRepository = $roleRepository;

        parent::__construct();
    }

    protected function setCustomViewDataEdit()
    {
        $this->viewData['permissionData'] = Permission::query()
            ->where(['guard' => 'admin', 'active' => true])
            ->orderBy('id')
            ->get()
            ->groupBy('group');
    }

    /**
     * Model Update
     *
     * @param string $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $this->checkPermissionEdit();

        $this->checkValidate();

        $model = $this->modelRepository->find($id) ?? abort(404);

        $inputSet = $request->input($this->pageData->getAttribute('model'));

        // 儲存更新資料
        try {
            \DB::beginTransaction();

            if ($this->modelRepository->save($model, $inputSet)) {
                $model->syncPermissions($request->input('Permission', []));
                \DB::commit();

                LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('admin.form.message.edit_success'));
                return redirect(langRoute("admin.{$this->uri}.edit", [$id]))->with('success', __('admin.form.message.edit_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('admin.form.message.edit_error'));
        return redirect(langRoute("admin.{$this->uri}.edit", [$id]))->withErrors([__('admin.form.message.edit_error')])->withInput();
    }
}
