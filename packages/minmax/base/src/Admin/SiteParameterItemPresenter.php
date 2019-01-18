<?php

namespace Minmax\Base\Admin;

/**
 * Class SiteParameterItemPresenter
 */
class SiteParameterItemPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['label', 'details'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'group_id' => (new SiteParameterGroupRepository)->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }

    public function getFieldSelect($model, $column, $options = [])
    {
        if ($column == 'group_id') {
            $this->parameterSet['group_id'] = (new SiteParameterGroupRepository)->getSelectParameters(true);
        }

        return parent::getFieldSelect($model, $column, $options);
    }
}