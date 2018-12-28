<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\Permission;

/**
 * Class RolePresenter
 */
class RolePresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['display_name', 'description'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'guard' => [
                'admin' => ['title' => 'Admin', 'options' => []],
                'web' => ['title' => 'Web', 'options' => []],
            ],
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param  \Minmax\Base\Models\Role $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldPermissions($model)
    {
        return view('MinmaxBase::admin.role.form-permission', [
            'model' => $model,
            'permissionData' => Permission::query()
                ->where('active', true)
                ->orderBy('sort')
                ->get()
                ->groupBy('group'),
        ]);
    }
}