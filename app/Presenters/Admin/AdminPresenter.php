<?php

namespace App\Presenters\Admin;

use App\Models\Role;

class AdminPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'role_id' => Role::orderBy('display_name')->get()->mapWithKeys(function($item, $key) {
                return [$item->id => $item->display_name];
            }),
            'active' => [
                '1' => __('models.Admin.selection.active.1'),
                '0' => __('models.Admin.selection.active.0'),
            ],
        ];
    }
}