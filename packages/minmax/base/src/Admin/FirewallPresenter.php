<?php

namespace Minmax\Base\Admin;

class FirewallPresenter extends Presenter
{
    public function __construct()
    {
        $this->parameterSet = [
            'rule' => systemParam('rule'),
            'active' => systemParam('active'),
        ];
    }
}