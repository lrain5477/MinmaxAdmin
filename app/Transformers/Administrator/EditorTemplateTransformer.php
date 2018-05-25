<?php

namespace App\Transformers\Administrator;

use App\Models\EditorTemplate;

class EditorTemplateTransformer extends Transformer
{
    protected $model = 'EditorTemplate';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param EditorTemplate $model
     * @return array
     * @throws \Throwable
     */
    public function transform(EditorTemplate $model)
    {
        return [
            'guard' => $this->getGridText($model->guard),
            'category' => $this->getGridText($model->category),
            'title' => $this->getGridText($model->title),
            'sort' => $this->getGridSort($model->guard, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}