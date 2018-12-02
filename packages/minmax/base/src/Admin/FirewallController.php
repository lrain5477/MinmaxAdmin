<?php

namespace Minmax\Base\Admin;

class FirewallController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(FirewallRepository $firewallRepository)
    {
        $this->modelRepository = $firewallRepository;

        parent::__construct();
    }
}
