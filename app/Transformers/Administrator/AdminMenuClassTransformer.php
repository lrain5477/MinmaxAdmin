<?php

namespace App\Transformers\Administrator;

use App\Models\AdminMenuClass;

class AdminMenuClassTransformer extends Transformer
{
    protected $model = 'AdminMenuClass';

    /**
     * @param AdminMenuClass $model
     * @return array
     * @throws \Throwable
     */
    public function transform(AdminMenuClass $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}