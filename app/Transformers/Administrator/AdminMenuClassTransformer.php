<?php

namespace App\Transformers\Administrator;

use App\Models\AdminMenu;

class AdminMenuClassTransformer extends Transformer
{
    protected $model = 'AdminMenuClass';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param AdminMenu $model
     * @return array
     * @throws \Throwable
     */
    public function transform(AdminMenu $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}