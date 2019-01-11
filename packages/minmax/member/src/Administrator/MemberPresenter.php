<?php

namespace Minmax\Member\Administrator;

use Minmax\Base\Administrator\Presenter;
use Minmax\Base\Administrator\RoleRepository;

/**
 * Class MemberPresenter
 */
class MemberPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxMember::';

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'role_id' => (new RoleRepository)->getSelectParameters('web'),
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param  \Minmax\Member\Models\Member $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldRolesSelect($model)
    {
        return view('MinmaxBase::administrator.layouts.form.multi-select', [
            'id' => 'Member-role_id',
            'language' => false,
            'label' => __('MinmaxMember::models.Member.role_id'),
            'name' => 'Member[role_id][]',
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