<?php

namespace Minmax\Base\Admin;

use Illuminate\Http\Request;
use Minmax\Base\Helpers\Log as LogHelper;
use Minmax\Base\Models\Permission;

class RoleController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(RoleRepository $roleRepository)
    {
        $this->modelRepository = $roleRepository;

        parent::__construct();
    }
}
