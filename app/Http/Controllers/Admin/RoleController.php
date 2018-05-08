<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PermissionHelper;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\WebData;
use App\Repositories\Admin\Repository;
use Auth;
use Breadcrumbs;
use Illuminate\Http\Request;
use Validator;

class RoleController extends Controller
{
    public function __construct(Repository $modelRepository)
    {
        parent::__construct($modelRepository);

        $this->adminData = Auth::guard('admin')->user();
        $this->viewData['adminData'] = $this->adminData;
        $this->viewData['menuData'] = $this->getMenuData();
        $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'admin'])->first();
    }

    /**
     * Model Edit
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function edit($id)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(404);

        $this->viewData['formDataId'] = $id;
        $this->viewData['formData'] = $this->modelRepository->one([$this->modelRepository->getIndexKey() => $id]);
        $this->viewData['permissionData'] = Permission::Where(['guard' => $this->viewData['formData']->guard, 'active' => 1])->get()->groupBy('group');

        // 設定麵包屑導航
        Breadcrumbs::register('edit', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push(
                $this->pageData->title,
                $this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === true
                    ? route('admin.index', [$this->uri])
                    : null
            );
            $breadcrumbs->push(__('admin.form.edit'));
        });

        try {
            return view('admin.' . $this->uri . '.edit', $this->viewData);
        } catch(\Exception $e) {
            return abort(404);
        }
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
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(404);

        $validator = Validator::make($request->input($this->pageData->model), $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            try {
                \DB::beginTransaction();

                $this->modelRepository->save($request->input($this->pageData->model), [$this->modelRepository->getIndexKey() => $id]);
                $permissionData = $request->input('PermissionRole');
                $permissionRoleData = [];
                foreach ($permissionData as $permission_id) {
                    $permissionRoleData[] = [
                        'permission_id' => $permission_id,
                        'role_id' => $id
                    ];
                }
                PermissionRole::where('role_id', $id)->delete();
                if(count($permissionRoleData) > 0) {
                    PermissionRole::insert($permissionRoleData);
                }

                \DB::commit();

                return redirect()->route('admin.edit', [$this->uri, $id])->with('success', __('admin.form.message.edit_success'));
            } catch (\Exception $e) {
                \DB::rollBack();

                return redirect()->route('admin.edit', [$this->uri, $id])->withErrors([__('admin.form.message.edit_error')])->withInput();
            }
        }

        return redirect()->route('admin.edit', [$this->uri, $id])->withErrors($validator)->withInput();
    }
}
