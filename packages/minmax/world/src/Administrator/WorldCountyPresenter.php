<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Presenter;

/**
 * Class WorldCountyPresenter
 */
class WorldCountyPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxWorld::';

    protected $languageColumns = ['name'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'state_id' => (new WorldStateRepository())->getSelectParameters(),
            'active' => systemParam('active'),
        ];
    }
}