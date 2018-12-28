<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Controller;

/**
 * Class WorldLanguageController
 */
class WorldLanguageController extends Controller
{
    protected $packagePrefix = 'MinmaxWorld::';

    public function __construct(WorldLanguageRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
