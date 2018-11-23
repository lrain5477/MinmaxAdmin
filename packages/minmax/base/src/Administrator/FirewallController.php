<?php

namespace App\Http\Controllers\Administrator;

use App\Repositories\Administrator\FirewallRepository;
use Illuminate\Http\Request;

class FirewallController extends Controller
{
    public function __construct(Request $request, FirewallRepository $firewallRepository)
    {
        $this->modelRepository = $firewallRepository;

        parent::__construct($request);
    }
}
