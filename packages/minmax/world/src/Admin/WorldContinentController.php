<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Controller;

class WorldContinentController extends Controller
{
    protected $packagePrefix = 'MinmaxWorld::';

    public function __construct(WorldContinentRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
