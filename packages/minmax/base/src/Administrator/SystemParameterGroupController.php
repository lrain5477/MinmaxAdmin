<?php

namespace Minmax\Base\Administrator;

/**
 * Class SystemParameterGroupController
 */
class SystemParameterGroupController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(SystemParameterGroupRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
