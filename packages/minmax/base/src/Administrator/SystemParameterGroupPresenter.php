<?php

namespace Minmax\Base\Administrator;

/**
 * Class SystemParameterGroupPresenter
 */
class SystemParameterGroupPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['title'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}