<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\AdminRepository;
use Minmax\Base\Administrator\Presenter;

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