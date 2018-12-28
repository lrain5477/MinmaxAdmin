<?php

namespace Minmax\Base\Admin;

/**
 * Class FirewallController
 */
class FirewallController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(FirewallRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
