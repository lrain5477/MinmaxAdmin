<?php

namespace App\Transformers\Administrator;

use App\Models\Language;

class LanguageTransformer extends Transformer
{
    protected $uri = 'language';
    protected $model = 'Language';

    /**
     * @param Language $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Language $model)
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