<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Controller;

/**
 * Class WorldStateController
 */
class WorldStateController extends Controller
{
    protected $packagePrefix = 'MinmaxWorld::';

    public function __construct(WorldStateRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
