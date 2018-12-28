<?php

namespace Minmax\Base\Administrator;

/**
 * Class FirewallPresenter
 */
class FirewallPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'guard' => [
                'admin' => ['title' => 'Admin', 'options' => []],
                'web' => ['title' => 'Web', 'options' => []],
            ],
            'rule' => systemParam('rule'),
            'active' => systemParam('active'),
        ];
    }
}