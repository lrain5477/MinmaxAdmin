<?php

namespace App\Transformers\Administrator;

use App\Models\SystemParameter;

class ParameterGroupTransformer extends Transformer
{
    protected $model = 'ParameterGroup';
    protected $parameterSet = [
        'admin' => 'admin',
        'active' => 'active',
    ];

    /**
     * @param SystemParameter $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SystemParameter $model)
    {
        return [
            'code' => $this->getGridText($model->code),
            'title' => $this->getGridText($model->title),
            'admin' => $this->getGridSwitch($model->guid, 'admin', $model->admin),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}