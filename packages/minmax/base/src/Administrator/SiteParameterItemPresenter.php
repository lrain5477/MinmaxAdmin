<?php

namespace Minmax\Base\Administrator;

/**
 * Class SiteParameterItemPresenter
 */
class SiteParameterItemPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['label'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'group_id' => (new SiteParameterGroupRepository)->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}