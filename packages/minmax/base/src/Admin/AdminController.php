<?php

namespace Minmax\Base\Admin;

class AdminController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(AdminRepository $adminRepository)
    {
        $this->modelRepository = $adminRepository;

        parent::__construct();
    }

    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()->where('username', '!=', 'sysadmin');
    }
}
