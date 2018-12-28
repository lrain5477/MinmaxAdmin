<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Controller;

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
