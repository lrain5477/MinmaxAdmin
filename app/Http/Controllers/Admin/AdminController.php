<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Helpers\PermissionHelper;
use App\Models\RoleAdmin;
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

                $roleInsert = [];
                foreach($input['role_id'] ?? [] as $roleItem) $roleInsert[] = ['role_id' => $roleItem, 'user_id' => $input['guid']];
                if(count($roleInsert) > 0) {
                    RoleAdmin::insert($roleInsert);
                }
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
            if(!isset($input['password']) || is_null($input['password']) || $input['password'] == '') {
                unset($input['password']);
            } else {
                $input['password'] = \Hash::make($input['password']);
            }
            if(array_key_exists('password_confirmation', $input)) unset($input['password_confirmation']);

            try {
                \DB::beginTransaction();

                RoleAdmin::where('user_id', $id)->delete();
                $roleInsert = [];
                foreach($input['role_id'] ?? [] as $roleItem) $roleInsert[] = ['role_id' => $roleItem, 'user_id' => $id];
                if(count($roleInsert) > 0) {
                    RoleAdmin::insert($roleInsert);
                }
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

    /**
     * Grid data return for DataTables
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function ajaxDataTable(Request $request)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === false) return abort(403);

        $where = [];
        if($this->modelRepository->isMultiLanguage()) $where['lang'] = app()->getLocale();

        $datatables = \DataTables::of($this->modelRepository->query($where)->where('username', '!=', 'sysadmin'));

        if($request->has('filter') || $request->has('equal')) {
            $datatables->filter(function($query) use ($request) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $whereQuery = '';
                $whereValue = [];
                if($request->has('filter')) {
                    foreach ($request->input('filter') as $column => $value) {
                        if (is_null($value) || $value === '') continue;
                        if ($whereQuery === '') {
                            $whereQuery .= "{$column} like ?";
                        } else {
                            $whereQuery .= " or {$column} like ?";
                        }
                        $whereValue[] = "%{$value}%";
                    }
                    if($whereQuery !== '') $whereQuery = "({$whereQuery})";
                }
                if($request->has('equal')) {
                    foreach($request->input('equal') as $column => $value) {
                        if(is_null($value) || $value === '') continue;
                        if($whereQuery === '') {
                            $whereQuery .= "{$column} = ?";
                        } else {
                            $whereQuery .= " and {$column} = ?";
                        }
                        $whereValue[] = "{$value}";
                    }
                }

                if($whereQuery !== '' && count($whereValue) > 0)
                    $query->whereRaw("{$whereQuery}", $whereValue);
            });
        }

        return $datatables
            ->setTransformer(app()->make('App\\Transformers\\Admin\\' . $this->pageData->getAttribute('model') . 'Transformer', ['uri' => $this->uri]))
            ->make(true);
    }
}
