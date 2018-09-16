<?php

namespace App\Presenters\Administrator;

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