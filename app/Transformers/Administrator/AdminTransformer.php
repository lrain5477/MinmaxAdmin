<?php

namespace App\Transformers\Administrator;

use App\Models\Admin;

class AdminTransformer extends Transformer
{
    protected $model = 'Admin';
    protected $parameterSet = [
        'active',
    ];

    /**
     * @param Admin $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Admin $model)
    {
        return [
            'username' => $this->getGridText($model->username),
            'name' => $this->getGridText($model->name),
            'email' => $this->getGridText($model->email),
            'role_id' => $this->getGridText($model->roles()->get()->map(function($item) { return $item->display_name; })->implode(', ')),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}