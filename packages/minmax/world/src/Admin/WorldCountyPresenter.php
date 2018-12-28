<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Presenter;

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