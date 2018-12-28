<?php

namespace Minmax\Base\Admin;

/**
 * Class SiteParameterGroupPresenter
 */
class SiteParameterGroupPresenter extends Presenter
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