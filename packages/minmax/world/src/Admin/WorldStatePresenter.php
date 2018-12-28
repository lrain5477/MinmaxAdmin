<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Presenter;

/**
 * Class WorldStatePresenter
 */
class WorldStatePresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxWorld::';

    protected $languageColumns = ['name'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'country_id' => (new WorldCountryRepository())->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}