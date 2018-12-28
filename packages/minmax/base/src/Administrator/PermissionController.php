<?php

namespace Minmax\Base\Administrator;

/**
 * Class PermissionController
 */
class PermissionController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(PermissionRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
