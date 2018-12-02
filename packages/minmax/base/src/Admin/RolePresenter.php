<?php

namespace Minmax\Base\Admin;

class RolePresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}