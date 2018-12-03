<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Permission;

class RolePresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }

    public function getFieldPermissions($model)
    {
        return view('MinmaxBase::admin.role.field-permission', [
            'model' => $model,
            'permissionData' => Permission::query()
                ->where(['guard' => 'admin', 'active' => true])
                ->orderBy('id')
                ->get()
                ->groupBy('group'),
        ]);
    }
}