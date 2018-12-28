<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Controller;

/**
 * Class WorldCurrencyController
 */
class WorldCurrencyController extends Controller
{
    protected $packagePrefix = 'MinmaxWorld::';

    public function __construct(WorldCurrencyRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
