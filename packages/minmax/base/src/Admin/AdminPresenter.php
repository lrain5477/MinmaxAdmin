<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Role;

class AdminPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        $this->parameterSet = [
            'role_id' => Role::query()
                ->orderBy('display_name')
                ->get()
                ->mapWithKeys(function($item) {
                    /** @var \Minmax\Base\Models\Role $item */
                    return [$item->id => ['title' => $item->display_name, 'class' => null]];
                })
                ->toArray(),
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