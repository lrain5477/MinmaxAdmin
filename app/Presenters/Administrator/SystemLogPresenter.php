<?php

namespace App\Presenters\Administrator;

class SystemLogPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'result' => [
                '1' => __('models.SystemLog.selection.result.1'),
                '0' => __('models.SystemLog.selection.result.0'),
            ],
        ];
    }
}