<?php

namespace App\Presenters\Administrator;

class WebDataPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'active' => [
                '1' => __('models.WebData.selection.active.1'),
                '0' => __('models.WebData.selection.active.0'),
            ],
        ];
    }
}