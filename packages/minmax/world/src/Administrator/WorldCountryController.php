<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Controller;

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
