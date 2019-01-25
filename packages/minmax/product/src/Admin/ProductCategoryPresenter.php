<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Presenter;

/**
 * Class ProductCategoryPresenter
 */
class ProductCategoryPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxProduct::';

    protected $languageColumns = ['title', 'details'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'parent_id' => (new ProductCategoryRepository)->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}