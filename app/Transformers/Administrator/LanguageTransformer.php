<?php

namespace App\Transformers\Administrator;

use App\Models\WorldLanguage;

class LanguageTransformer extends Transformer
{
    protected $model = 'Language';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param WorldLanguage $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldLanguage $model)
    {
        return [
            'guid' => $this->getGridCheckBox($model->guid),
            'title' => $this->getGridText($model->title),
            'codes' => $this->getGridText($model->codes),
            'name' => $this->getGridText($model->name),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}