<?php

namespace App\Transformers\Administrator;

use App\Models\Permission;

class PermissionTransformer extends Transformer
{
    protected $model = 'Permission';

    /**
     * @param Permission $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Permission $model)
    {
        return [
            'guard' => $this->getGridText($model->guard),
            'name' => $this->getGridText($model->name),
            'display_name' => $this->getGridText($model->display_name),
            'active' => $this->getGridSwitch($model->id, 'active', $model->active),
            'action' => $this->getGridActions($model->id),
        ];
    }
}