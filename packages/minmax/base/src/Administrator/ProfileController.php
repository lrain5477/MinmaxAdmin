<?php

namespace Minmax\Base\Administrator;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ProfileController
 */
class ProfileController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(AdministratorRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
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
            $breadcrumbs->push(__('MinmaxBase::administrator.header.account'));
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
     * Model Update
     *
     * @param  Request $request
     * @param  null $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id = null)
    {
        $this->checkValidate();

        $id = $this->adminData->id;

        $model = $this->modelRepository->find($id) ?? abort(404);

        $inputSet = $request->input('Administrator');

        // 儲存更新資料
        try {
            \DB::beginTransaction();

            if ($this->modelRepository->save($model, $inputSet)) {
                \DB::commit();
                LogHelper::system('administrator', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.edit_success'));
                return redirect(langRoute("administrator.profile"))->with('success', __('MinmaxBase::administrator.form.message.edit_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('administrator', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.edit_error'));
        return redirect(langRoute("administrator.profile"))->withErrors([__('MinmaxBase::administrator.form.message.edit_error')])->withInput();
    }
}
