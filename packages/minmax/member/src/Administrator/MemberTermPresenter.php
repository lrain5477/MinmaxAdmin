<?php

namespace Minmax\Member\Administrator;

use Minmax\Base\Administrator\Presenter;

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