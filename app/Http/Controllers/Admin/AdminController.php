<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Helpers\PermissionHelper;
use App\Models\RoleAdmin;
use App\Models\WebData;
use App\Repositories\Admin\Repository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class AdminController extends Controller
{
    /**
     * Model Store
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Create')) === false) return abort(404);

        $validator = Validator::make($request->input($this->pageData->getAttribute('model')), $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            $input = $request->input($this->pageData->getAttribute('model'));
            $input['guid'] = Str::uuid();
            $input['password'] = \Hash::make('123456');

            try {
                \DB::beginTransaction();

                RoleAdmin::create(['role_id' =>$input['role_id'], 'user_id' => $input['guid']]);
                unset($input['role_id']);
                $modelData = $this->modelRepository->create($input);

                \DB::commit();

                LogHelper::system('admin', $this->uri, 'store', $modelData->guid, $this->adminData->username, 1, __('admin.form.message.create_success'));
                return redirect()->route('admin.edit', [$this->uri, $modelData->guid])->with('success', __('admin.form.message.create_success'));
            } catch (\Exception $e) {
                \DB::rollBack();

                return redirect()->route('admin.create', [$this->uri])->withErrors([__('admin.form.message.create_error')])->withInput();
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
        $validator = Validator::make($request->input($this->pageData->getAttribute('model')), $validateRules);

        if($validator->passes()) {
            $input = $request->input($this->pageData->getAttribute('model'));
            if(isset($input['password']) && is_null($input['password'])) {
                unset($input['password']);
            } else {
                $input['password'] = \Hash::make($input['password']);
            }
            if(array_key_exists('password_confirmation', $input)) unset($input['password_confirmation']);

            try {
                \DB::beginTransaction();

                RoleAdmin::where('user_id', $id)->update(['role_id' => $input['role_id']]);
                unset($input['role_id']);
                $this->modelRepository->save($input, [$this->modelRepository->getIndexKey() => $id]);

                \DB::commit();

                LogHelper::system('admin', $this->uri, 'update', $id, $this->adminData->username, 1, __('admin.form.message.edit_success'));
                return redirect()->route('admin.edit', [$this->uri, $id])->with('success', __('admin.form.message.edit_success'));
            } catch (\Exception $e) {
                \DB::rollBack();

                LogHelper::system('admin', $this->uri, 'update', $id, $this->adminData->username, 0, __('admin.form.message.edit_error'));
                return redirect()->route('admin.edit', [$this->uri, $id])->withErrors([__('admin.form.message.edit_error')])->withInput();
            }
        }

        LogHelper::system('admin', $this->uri, 'update', $id, $this->adminData->username, 0, $validator->errors()->first());
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

        if($this->adminData->guid === $id) {
            LogHelper::system('admin', $this->uri, 'destroy', $id, $this->adminData->username, 0, 'Can not delete self account');
            return redirect()->route('admin.index', [$this->uri])->withErrors([__('admin.form.message.delete_error')]);
        }

        try {
            \DB::beginTransaction();

            $this->modelRepository->delete([$this->modelRepository->getIndexKey() => $id]);
            RoleAdmin::where('user_id', $id)->delete();

            \DB::commit();

            LogHelper::system('admin', $this->uri, 'destroy', $id, $this->adminData->username, 1, __('admin.form.message.delete_success'));
            return redirect()->route('admin.index', [$this->uri])->with('success', __('admin.form.message.delete_success'));
        } catch (\Exception $e) {
            \DB::rollBack();

            LogHelper::system('admin', $this->uri, 'destroy', $id, $this->adminData->username, 0, __('admin.form.message.delete_error'));
            return redirect()->route('admin.index', [$this->uri])->withErrors([__('admin.form.message.delete_error')]);
        }
    }
}
