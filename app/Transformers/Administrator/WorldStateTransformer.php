<?php

namespace App\Transformers\Administrator;

use App\Models\WorldState;

class WorldStateTransformer extends Transformer
{
    protected $model = 'WorldState';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param WorldState $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldState $model)
    {
        return [
            'country_id' => $this->getGridText($model->worldCountry->name),
            'title' => $this->getGridText($model->title),
            'name' => $this->getGridText($model->name),
            'code' => $this->getGridText($model->code),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}