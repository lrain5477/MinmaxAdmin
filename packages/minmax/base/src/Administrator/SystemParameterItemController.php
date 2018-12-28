<?php

namespace Minmax\Base\Administrator;

/**
 * Class SystemParameterItemGroupController
 */
class SystemParameterItemController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(SystemParameterItemRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
