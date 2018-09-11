<?php

namespace App\Presenters\Admin;

class FirewallPresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'rule' => systemParam('rule'),
            'active' => systemParam('active'),
        ];
    }
}