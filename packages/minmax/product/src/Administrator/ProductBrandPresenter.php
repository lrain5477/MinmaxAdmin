<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Presenter;

/**
 * Class ProductBrandPresenter
 */
class ProductBrandPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxProduct::';

    protected $languageColumns = ['title', 'details'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}