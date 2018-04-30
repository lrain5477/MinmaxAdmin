<?php

namespace App\Presenters\Administrator;

class ProfilePresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'active' => [
                '0' => __('models.Administrator.selection.active.0'),
                '1' => __('models.Administrator.selection.active.1'),
            ],
        ];
    }
}