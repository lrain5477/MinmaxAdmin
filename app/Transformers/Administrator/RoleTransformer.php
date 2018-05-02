<?php

namespace App\Transformers\Administrator;

use App\Models\Role;

class RoleTransformer extends Transformer
{
    protected $uri = 'role';
    protected $model = 'Role';

    /**
     * @param Role $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Role $model)
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