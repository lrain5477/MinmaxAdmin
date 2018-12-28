<?php

namespace Minmax\Base\Administrator;

/**
 * Class AdministratorPresenter
 */
class AdministratorPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}