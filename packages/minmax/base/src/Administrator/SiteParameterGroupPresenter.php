<?php

namespace Minmax\Base\Administrator;

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
            'editable' => systemParam('editable'),
        ];
    }
}