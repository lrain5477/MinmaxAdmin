<?php

namespace Minmax\Base\Administrator;

/**
 * Class ColumnExtensionPresenter
 */
class ColumnExtensionPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['title'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'table_name' => (new ColumnExtensionRepository)->getTables(),
            'active' => systemParam('active'),
        ];
    }
}