<?php

namespace App\Transformers\Administrator;

use App\Models\WorldLanguage;

class WorldLanguageTransformer extends Transformer
{
    protected $model = 'WorldLanguage';
    protected $parameterSet = [
        'active',
    ];

    /**
     * @param WorldLanguage $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldLanguage $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'name' => $this->getGridText($model->name),
            'code' => $this->getGridText($model->code),
            'sort' => $this->getGridSort($model->id, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->id, 'active', $model->active),
            'action' => $this->getGridActions($model->id),
        ];
    }
}