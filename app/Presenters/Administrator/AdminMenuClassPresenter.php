<?php

namespace App\Presenters\Administrator;

class AdminMenuClassPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'active' => [
                '1' => __('models.AdminMenuClass.selection.active.1'),
                '0' => __('models.AdminMenuClass.selection.active.0'),
            ],
        ];
    }
}