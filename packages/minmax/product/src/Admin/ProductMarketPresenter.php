<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\AdminRepository;
use Minmax\Base\Admin\Presenter;

/**
 * Class ProductMarketPresenter
 */
class ProductMarketPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxProduct::';

    protected $languageColumns = ['title', 'details'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'admin_id' => (new AdminRepository)->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}