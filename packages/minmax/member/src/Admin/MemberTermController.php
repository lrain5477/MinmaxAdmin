<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class MemberTermController
 */
class MemberTermController extends Controller
{
    protected $packagePrefix = 'MinmaxMember::';

    public function __construct(MemberTermRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
