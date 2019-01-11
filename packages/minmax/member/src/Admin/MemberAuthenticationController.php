<?php

namespace Minmax\Member\Admin;

use Illuminate\Http\Request;
use Minmax\Base\Admin\Controller;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class MemberAuthenticationController
 */
class MemberAuthenticationController extends Controller
{
    protected $packagePrefix = 'MinmaxMember::';

    public function __construct(MemberAuthenticationRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * Model Store
     *
     * @param  Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkPermissionEdit();

        $memberId = $request->route('id');

        $inputSet = $request->input($this->pageData->getAttribute('model') . 'Authentication');
        $inputSet['member_id'] = $memberId;

        // 儲存新建資料
        try {
            \DB::beginTransaction();

            if ($modelData = $this->modelRepository->create($inputSet)) {
                \DB::commit();
                LogHelper::system('admin', $request->path(), $request->method(), $memberId, $this->adminData->username, 1, __('MinmaxBase::admin.form.message.create_success'));
                return redirect(langRoute("admin.{$this->uri}.edit", [$memberId]))->with('success', __('MinmaxBase::admin.form.message.create_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('admin', $request->path(), $request->method(), $memberId, $this->adminData->username, 0, __('MinmaxBase::admin.form.message.create_error'));
        return redirect(langRoute("admin.{$this->uri}.edit", [$memberId]))->withErrors([__('MinmaxBase::admin.form.message.create_error')])->withInput();
    }

    /**
     * Authentication Update
     *
     * @param  string $token
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function authenticate($token)
    {
        $this->checkPermissionEdit();

        $model = $this->modelRepository->find($token) ?? abort(404);

        if (! $model->authenticated) {
            // 儲存更新資料
            try {
                \DB::beginTransaction();

                if ($this->modelRepository->save($model, ['authenticated' => true, 'authenticated_at' => date('Y-m-d H:i:s')])) {
                    \DB::commit();
                    LogHelper::system('admin', request()->path(), 'GET', $model->member_id, $this->adminData->username, 1, __('MinmaxMember::admin.form.message.authentication.edit_success'));
                    return redirect(langRoute("admin.{$this->uri}.edit", [$model->member_id]))->with('success', __('MinmaxMember::admin.form.message.authentication.edit_success'));
                }

                \DB::rollBack();
            } catch (\Exception $e) {
                \DB::rollBack();
            }
        }

        LogHelper::system('admin', request()->path(), 'GET', $model->member_id, $this->adminData->username, 0, __('MinmaxMember::admin.form.message.authentication.edit_error'));
        return redirect(langRoute("admin.{$this->uri}.edit", [$model->member_id]))->withErrors([__('MinmaxMember::admin.form.message.authentication.edit_error')])->withInput();
    }

    /**
     * Model Destroy
     *
     * @param  Request $request
     * @param  string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $this->checkPermissionEdit();

        $model = $this->modelRepository->find($id) ?? abort(404);

        if ($this->modelRepository->delete($model)) {
            LogHelper::system('admin', $request->path(), $request->method(), $model->member_id, $this->adminData->username, 1, __('MinmaxMember::admin.form.message.authentication.delete_success'));
            return redirect(langRoute("admin.{$this->uri}.edit", [$model->member_id]))->with('success', __('MinmaxMember::admin.form.message.authentication.delete_success'));
        }

        LogHelper::system('admin', $request->path(), $request->method(), $model->member_id, $this->adminData->username, 0, __('MinmaxMember::admin.form.message.authentication.delete_error'));
        return redirect(langRoute("admin.{$this->uri}.edit", [$model->member_id]))->withErrors([__('MinmaxMember::admin.form.message.authentication.delete_error')]);
    }
}
