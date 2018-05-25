<?php

namespace App\Transformers\Administrator;

use App\Models\ParameterItem;

class ParameterItemTransformer extends Transformer
{
    protected $model = 'ParameterItem';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param ParameterItem $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ParameterItem $model)
    {
        return [
            'group' => $this->getGridText($model->parameterGroup->title),
            'title' => $this->getGridText($model->title),
            'value' => $this->getGridText($model->value),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}