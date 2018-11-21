<?php

namespace Minmax\Base\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(Request $request, AdminRepository $adminRepository)
    {
        $this->modelRepository = $adminRepository;

        parent::__construct($request);
    }

    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()->where('username', '!=', 'sysadmin');
    }
}
