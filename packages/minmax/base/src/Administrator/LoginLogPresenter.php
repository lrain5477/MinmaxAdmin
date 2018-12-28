<?php

namespace Minmax\Base\Administrator;

/**
 * Class LoginLogPresenter
 */
class LoginLogPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'guard' => [
                'administrator' => ['title' => 'Administrator', 'options' => []],
                'admin' => ['title' => 'Admin', 'options' => []],
                'web' => ['title' => 'Web', 'options' => []],
            ],
            'result' => systemParam('result'),
        ];
    }
}