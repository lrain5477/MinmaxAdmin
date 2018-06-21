<?php

namespace App\Transformers\Administrator;

use App\Models\WorldCountry;

class WorldCountryTransformer extends Transformer
{
    protected $model = 'WorldCountry';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param WorldCountry $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldCountry $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'name' => $this->getGridText($model->name),
            'code' => $this->getGridText($model->code),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}