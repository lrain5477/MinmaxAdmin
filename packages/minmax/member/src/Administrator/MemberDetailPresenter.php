<?php

namespace Minmax\Member\Administrator;

use Minmax\Base\Administrator\Presenter;

/**
 * Class MemberDetailPresenter
 */
class MemberDetailPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxMember::';

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [];
    }
}