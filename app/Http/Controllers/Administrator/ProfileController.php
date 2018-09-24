<?php

namespace App\Http\Controllers\Administrator;

use App\Helpers\LogHelper;
use App\Http\Requests\Administrator\ProfileRequest;
use App\Repositories\Administrator\AdministratorRepository;
use Illuminate\Http\Request;
use Breadcrumbs;

/**
 * Class ProfileController
 * @property \App\Models\Administrator $adminData
 */
class ProfileController extends Controller
{
    public function __construct(Request $request, AdministratorRepository $administratorRepository)
    {
        $this->modelRepository = $administratorRepository;

        parent::__construct($request);
    }

    /**
     * @param  string|integer $id
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsEdit($id)
    {
        Breadcrumbs::register('edit', function ($breadcrumbs) use ($id) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('administrator.home');
            $breadcrumbs->push(__('administrator.header.account'));
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
        $this->checkValidate();

        $model = $this->modelRepository->find($this->adminData->guid) ?? abort(404);

        $inputSet = $request->input('Administrator');

        // 儲存更新資料
        try {
            \DB::beginTransaction();

            if ($this->modelRepository->save($model, $inputSet)) {
                \DB::commit();
                LogHelper::system('administrator', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('administrator.form.message.edit_success'));
                return redirect(langRoute("administrator.profile"))->with('success', __('administrator.form.message.edit_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('administrator', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('administrator.form.message.edit_error'));
        return redirect(langRoute("administrator.profile"))->withErrors([__('administrator.form.message.edit_error')])->withInput();
    }
}
