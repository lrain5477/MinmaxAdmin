<?php

namespace Minmax\Base\Administrator;

/**
 * Class SiteParameterItemGroupController
 */
class SiteParameterItemController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(SiteParameterItemRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
