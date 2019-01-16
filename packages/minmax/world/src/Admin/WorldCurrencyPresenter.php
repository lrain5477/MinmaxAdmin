<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Presenter;

/**
 * Class WorldCurrencyPresenter
 */
class WorldCurrencyPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxWorld::';

    protected $languageColumns = ['name'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}