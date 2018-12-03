<?php

namespace Minmax\Base\Admin;

class WebDataPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}