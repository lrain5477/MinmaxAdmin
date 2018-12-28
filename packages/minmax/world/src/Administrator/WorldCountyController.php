<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Controller;

/**
 * Class WorldCountyController
 */
class WorldCountyController extends Controller
{
    protected $packagePrefix = 'MinmaxWorld::';

    public function __construct(WorldCountyRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
