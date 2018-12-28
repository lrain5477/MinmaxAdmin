<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Controller;

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
