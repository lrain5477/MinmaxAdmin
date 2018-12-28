<?php

namespace Minmax\Base\Administrator;

/**
 * Class SiteParameterGroupController
 */
class SiteParameterGroupController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(SiteParameterGroupRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
