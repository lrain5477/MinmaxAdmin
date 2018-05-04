<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Repositories\Administrator\Repository;
use Breadcrumbs;
use Illuminate\Http\Request;
use Validator;

class RoleController extends Controller
{
    public function __construct(Repository $modelRepository)
    {
        $this->middleware('auth:administrator');

        parent::__construct($modelRepository);

        $this->adminData = \Auth::guard('administrator')->user();
        $this->viewData['adminData'] = $this->adminData;
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
        $this->viewData['formDataId'] = $id;
        $this->viewData['formData'] = $this->modelRepository->one([$this->modelRepository->getIndexKey() => $id]);
        $this->viewData['permissionData'] = Permission::Where(['guard' => $this->viewData['formData']->guard, 'active' => 1])->get()->groupBy('group');

        // 設定麵包屑導航
        Breadcrumbs::register('edit', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
            $breadcrumbs->push($this->pageData->title, route('administrator.index', [$this->uri]));
            $breadcrumbs->push(__('administrator.form.edit'));
        });

        try {
            return view('administrator.' . $this->uri . '.edit', $this->viewData);
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

                return redirect()->route('administrator.edit', [$this->uri, $id])->with('success', __('administrator.form.message.edit_success'));
            } catch (\Exception $e) {
                \DB::rollBack();

                return redirect()->route('administrator.edit', [$this->uri, $id])->withErrors([__('administrator.form.message.edit_error')])->withInput();
            }
        }

        return redirect()->route('administrator.edit', [$this->uri, $id])->withErrors($validator)->withInput();
    }
}
