<?php

namespace Minmax\Base\Admin;

/**
 * Class AdminPresenter
 */
class AdminPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'role_id' => (new RoleRepository)->getSelectParameters('admin'),
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param  \Minmax\Base\Models\Admin $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldRolesSelect($model)
    {
        return view('MinmaxBase::admin.layouts.form.multi-select', [
            'id' => 'Admin-role_id',
            'language' => false,
            'label' => __('MinmaxBase::models.Admin.role_id'),
            'name' => 'Admin[role_id][]',
            'values' => $model->roles->pluck('id')->toArray(),
            'required' => true,
            'title' => '',
            'group' => false,
            'size' => 10,
            'hint' => '',
            'listData' => $this->parameterSet['role_id'] ?? [],
        ]);
    }
}