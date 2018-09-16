<?php

namespace App\Transformers\Administrator;

use App\Models\WebData;

class WebDataTransformer extends Transformer
{
    protected $model = 'WebData';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param WebData $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WebData $model)
    {
        return [
            'guard' => $this->getGridText($model->guard),
            'website_name' => $this->getGridText($model->website_name),
            'system_email' => $this->getGridText($model->system_email),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid, ['R', 'U']),
        ];
    }
}