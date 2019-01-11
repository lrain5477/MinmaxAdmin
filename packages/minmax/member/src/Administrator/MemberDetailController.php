<?php

namespace Minmax\Member\Administrator;

use Illuminate\Http\Request;
use Minmax\Base\Administrator\Controller;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class MemberDetailController
 */
class MemberDetailController extends Controller
{
    protected $packagePrefix = 'MinmaxMember::';

    public function __construct(MemberDetailRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    protected function checkValidate()
    {
        try {
            $reflection = new \ReflectionClass(static::class);
            app($reflection->getNamespaceName() . '\\' . $this->pageData->getAttribute('model') . 'DetailRequest');
        } catch (\ReflectionException $e) {}
    }

    /**
     * Model Update
     *
     * @param  Request $request
     * @param  string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->checkValidate();

        $model = $this->modelRepository->find($id) ?? abort(404);

        $inputSet = $request->input($this->pageData->getAttribute('model') . 'Detail');

        $inputSet = $this->doFileUpload($inputSet, $request);

        // 儲存更新資料
        try {
            \DB::beginTransaction();

            if ($this->modelRepository->save($model, $inputSet)) {
                \DB::commit();
                LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.edit_success'));
                return redirect(langRoute("admin.{$this->uri}.edit", [$id]))->with('success', __('MinmaxBase::administrator.form.message.edit_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.edit_error'));
        return redirect(langRoute("admin.{$this->uri}.edit", [$id]))->withErrors([__('MinmaxBase::administrator.form.message.edit_error')])->withInput();
    }
}
