<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class WorldCountryController
 */
class WorldCountryController extends Controller
{
    protected $packagePrefix = 'MinmaxWorld::';

    public function __construct(WorldCountryRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
