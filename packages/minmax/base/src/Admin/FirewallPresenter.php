<?php

namespace Minmax\Base\Admin;

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
            'rule' => systemParam('rule'),
            'active' => systemParam('active'),
        ];
    }
}