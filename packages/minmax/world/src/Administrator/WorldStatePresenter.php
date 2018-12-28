<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Presenter;

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
            'country_id' => (new WorldCountryRepository)->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}