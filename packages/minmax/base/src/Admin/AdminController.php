<?php

namespace Minmax\Base\Admin;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(AdminRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()->where('username', '!=', 'sysadmin');
    }
}
