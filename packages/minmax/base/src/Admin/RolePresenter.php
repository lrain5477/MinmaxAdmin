<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Permission;

class RolePresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['display_name', 'description'];

    protected $permissions = [
        'R' => 'roleShow',
        'U' => 'roleEdit',
        'D' => 'roleDestroy',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active', session('admin-formLocal', app()->getLocale())),
        ];
    }

    public function getFieldPermissions($model)
    {
        return view('MinmaxBase::admin.role.form-permission', [
            'model' => $model,
            'permissionData' => Permission::query()
                ->where(['guard' => 'admin', 'active' => true])
                ->orderBy('id')
                ->get()
                ->groupBy('group'),
        ]);
    }
}