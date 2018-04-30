<?php

namespace App\Transformers\Administrator;

use App\Models\WebData;

class WebDataTransformer extends Transformer
{
    protected $uri = 'web-data';
    protected $model = 'WebData';

    /**
     * @param WebData $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WebData $model)
    {
        return [
            'website_name' => $this->getGridText($model->website_name),
            'system_email' => $this->getGridText($model->system_email),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}