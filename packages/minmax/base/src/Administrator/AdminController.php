<?php

namespace Minmax\Base\Administrator;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(AdminRepository $adminRepository)
    {
        $this->modelRepository = $adminRepository;

        parent::__construct();
    }
}
