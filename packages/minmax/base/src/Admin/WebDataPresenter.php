<?php

namespace Minmax\Base\Admin;

class WebDataPresenter extends Presenter
{
    public function __construct()
    {
        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}