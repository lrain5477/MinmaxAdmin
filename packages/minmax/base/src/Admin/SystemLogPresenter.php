<?php

namespace Minmax\Base\Admin;

/**
 * Class SystemLogPresenter
 */
class SystemLogPresenter extends Presenter
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