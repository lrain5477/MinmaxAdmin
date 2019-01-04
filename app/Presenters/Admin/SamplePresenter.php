<?php

namespace App\Presenters\Admin;

use Minmax\Base\Admin\Presenter;

/**
 * Class SamplePresenter
 */
class SamplePresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            //'active' => systemParam('active'),
        ];
    }
}