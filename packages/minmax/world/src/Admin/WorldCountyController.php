<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Controller;

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
