<?php

namespace App\Presenters\Web;

use Minmax\Base\Web\Presenter;

/**
 * Class SamplePresenter
 */
class SamplePresenter extends Presenter
{
    public function __construct()
    {
        $this->parameterSet = [
            //'active' => systemParam('active'),
        ];
    }
}