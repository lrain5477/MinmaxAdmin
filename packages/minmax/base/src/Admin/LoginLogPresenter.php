<?php

namespace Minmax\Base\Admin;

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
            'result' => systemParam('result', session('admin-formLocal', app()->getLocale())),
        ];
    }
}