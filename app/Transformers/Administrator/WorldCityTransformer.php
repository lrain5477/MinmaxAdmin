<?php

namespace App\Transformers\Administrator;

use App\Models\WorldCity;

class WorldCityTransformer extends Transformer
{
    protected $model = 'WorldCity';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param WorldCity $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldCity $model)
    {
        return [
            'state_id' => $this->getGridText($model->worldState->worldCountry->name . ' / ' . $model->worldState->name),
            'title' => $this->getGridText($model->title),
            'name' => $this->getGridText($model->name),
            'code' => $this->getGridText($model->code),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}