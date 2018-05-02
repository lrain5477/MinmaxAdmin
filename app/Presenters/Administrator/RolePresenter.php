<?php

namespace App\Presenters\Administrator;

class RolePresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'guard' => [
                'admin' => 'admin',
                'merchant' => 'merchant',
            ],
            'active' => [
                '1' => __('models.Role.selection.active.1'),
                '0' => __('models.Role.selection.active.0'),
            ],
        ];
    }
}