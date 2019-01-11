<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Presenter;

/**
 * Class MemberTermPresenter
 */
class MemberTermPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxMember::';

    protected $languageColumns = ['title', 'editor'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}