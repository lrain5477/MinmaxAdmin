<?php

namespace App\Http\Controllers\Administrator;

use App\Repositories\Administrator\AdminRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(Request $request, AdminRepository $adminRepository)
    {
        $this->modelRepository = $adminRepository;

        parent::__construct($request);
    }
}
