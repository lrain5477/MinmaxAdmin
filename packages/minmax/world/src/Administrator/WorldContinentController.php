<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Controller;

/**
 * Class WorldContinentController
 */
class WorldContinentController extends Controller
{
    protected $packagePrefix = 'MinmaxWorld::';

    public function __construct(WorldContinentRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
