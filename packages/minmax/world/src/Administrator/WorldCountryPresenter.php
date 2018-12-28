<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Presenter;

/**
 * Class WorldCountryPresenter
 */
class WorldCountryPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxWorld::';

    protected $languageColumns = ['name'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'continent_id' => (new WorldContinentRepository)->getSelectParameters(),
            'language_id' => (new WorldLanguageRepository)->getSelectParameters(true),
            'active' => systemParam('active'),
        ];
    }
}