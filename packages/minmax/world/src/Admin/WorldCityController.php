<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class WorldCityController
 */
class WorldCityController extends Controller
{
    protected $packagePrefix = 'MinmaxWorld::';

    public function __construct(WorldCityRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
