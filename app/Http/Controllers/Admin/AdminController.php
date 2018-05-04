<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PermissionHelper;
use App\Models\RoleAdmin;
use App\Repositories\Admin\Repository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class AdminController extends Controller
{
    public function __construct(Repository $modelRepository)
    {
        $this->middleware('auth:admin');

        parent::__construct($modelRepository);

        $this->adminData = Auth::guard('admin')->user();
        $this->viewData['adminData'] = $this->adminData;
        $this->viewData['menuData'] = $this->getMenuData();
    }

    /**
     * Model Store
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Create')) === false) return abort(404);

        $validator = Validator::make($request->input($this->pageData->model), $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            $input = $request->input($this->pageData->model);
            $input['guid'] = Str::uuid();
            $input['password'] = \Hash::make('123456');

            try {
                \DB::beginTransaction();

                $modelData = $this->modelRepository->create($input);
                RoleAdmin::create(['role_id' => $modelData->role_id, 'user_id' => $modelData->guid]);

                \DB::commit();

                return redirect()->route('admin.edit', [$this->uri, $modelData->guid])->with('success', __('admin.form.message.edit_success'));
            } catch (\Exception $e) {
                \DB::rollBack();

                return redirect()->route('admin.create', [$this->uri])->withErrors([__('admini.form.message.create_error')])->withInput();
            }
        }

        return redirect()->route('admin.create', [$this->uri])->withErrors($validator)->withInput();
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

        $validateRules = $this->modelRepository->getRules() ?? [];
        $validateRules += [
            'password' => 'nullable|confirmed|min:6',
            'password_confirmation' => 'required_with:password'
        ];
        $validator = Validator::make($request->input($this->pageData->model), $validateRules);

        if($validator->passes()) {
            $input = $request->input($this->pageData->model);
            if(isset($input['password']) && is_null($input['password'])) {
                unset($input['password']);
            } else {
                $input['password'] = \Hash::make($input['password']);
            }
            if(array_key_exists('password_confirmation', $input)) unset($input['password_confirmation']);

            try {
                \DB::beginTransaction();

                $this->modelRepository->save($input, [$this->modelRepository->getIndexKey() => $id]);
                RoleAdmin::where('user_id', $id)->update(['role_id' => $input['role_id']]);

                \DB::commit();

                return redirect()->route('admin.edit', [$this->uri, $id])->with('success', __('admin.form.message.edit_success'));
            } catch (\Exception $e) {
                \DB::rollBack();

                return redirect()->route('admin.edit', [$this->uri, $id])->withErrors([__('admin.form.message.edit_error')])->withInput();
            }
        }

        return redirect()->route('admin.edit', [$this->uri, $id])->withErrors($validator)->withInput();
    }

    /**
     * Model Destroy
     *
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Destroy')) === false) return abort(404);

        if($this->adminData->guid === $id)
            return redirect()->route('admin.index', [$this->uri])->withErrors([__('admin.form.message.delete_error')]);

        try {
            \DB::beginTransaction();

            $this->modelRepository->delete([$this->modelRepository->getIndexKey() => $id]);
            RoleAdmin::where('user_id', $id)->delete();

            \DB::commit();

            return redirect()->route('admin.index', [$this->uri])->with('success', __('admin.form.message.delete_success'));
        } catch (\Exception $e) {
            \DB::rollBack();

            return redirect()->route('admin.index', [$this->uri])->withErrors([__('admin.form.message.delete_error')]);
        }
    }
}
