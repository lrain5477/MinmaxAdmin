<?php

namespace Minmax\Base\Administrator;

/**
 * Class WebDataController
 */
class WebDataController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(WebDataRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}