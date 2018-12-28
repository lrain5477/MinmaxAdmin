<?php

namespace Minmax\Base\Admin;

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
            'active' => systemParam('active', session('admin-formLocal', app()->getLocale())),
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
                ->where(['guard' => 'admin', 'active' => true])
                ->orderBy('sort')
                ->get()
                ->groupBy('group'),
        ]);
    }
}