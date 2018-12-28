<?php

namespace Minmax\Base\Administrator;

/**
 * Class SystemParameterItemPresenter
 */
class SystemParameterItemPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['label'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'group_id' => (new SystemParameterGroupRepository)->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}