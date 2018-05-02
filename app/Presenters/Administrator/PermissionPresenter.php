<?php

namespace App\Presenters\Administrator;

class PermissionPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'guard' => [
                'admin' => 'admin',
                'merchant' => 'merchant',
            ],
            'active' => [
                '1' => __('models.Permission.selection.active.1'),
                '0' => __('models.Permission.selection.active.0'),
            ],
        ];
    }
}