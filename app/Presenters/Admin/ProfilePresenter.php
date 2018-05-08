<?php

namespace App\Presenters\Admin;

class ProfilePresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'active' => [
                '0' => __('models.Admin.selection.active.0'),
                '1' => __('models.Admin.selection.active.1'),
            ],
        ];
    }
}