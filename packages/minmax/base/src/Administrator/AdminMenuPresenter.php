<?php

namespace Minmax\Base\Administrator;

/**
 * Class AdminMenuPresenter
 */
class AdminMenuPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'parent_id' => (new AdminMenuRepository)->getSelectParameters(),
            'permission_key' => (new PermissionRepository)->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}