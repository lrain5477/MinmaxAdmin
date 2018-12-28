<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Controller;

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
