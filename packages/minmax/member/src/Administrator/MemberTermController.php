<?php

namespace Minmax\Member\Administrator;

use Minmax\Base\Administrator\Controller;

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
