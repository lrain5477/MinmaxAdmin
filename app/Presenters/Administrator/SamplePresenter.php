<?php

namespace App\Presenters\Administrator;

use Minmax\Base\Administrator\Presenter;

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