<?php

namespace Minmax\Base\Admin;

class FirewallController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(FirewallRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
