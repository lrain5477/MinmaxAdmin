<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Presenter;

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