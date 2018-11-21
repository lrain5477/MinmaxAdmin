<?php

namespace Minmax\Base\Admin;

use Illuminate\Http\Request;

class FirewallController extends Controller
{
    public function __construct(Request $request, FirewallRepository $firewallRepository)
    {
        $this->modelRepository = $firewallRepository;

        parent::__construct($request);
    }
}
