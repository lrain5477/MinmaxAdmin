<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Presenter;

/**
 * Class WorldCityPresenter
 */
class WorldCityPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxWorld::';

    protected $languageColumns = ['name'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'county_id' => (new WorldCountyRepository())->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}