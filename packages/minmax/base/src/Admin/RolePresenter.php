<?php

namespace Minmax\Base\Admin;

class RolePresenter extends Presenter
{
    public function __construct()
    {
        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}