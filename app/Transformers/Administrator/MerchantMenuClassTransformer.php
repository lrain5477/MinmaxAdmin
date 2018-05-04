<?php

namespace App\Transformers\Administrator;

use App\Models\MerchantMenuClass;

class MerchantMenuClassTransformer extends Transformer
{
    protected $model = 'MerchantMenuClass';

    /**
     * @param MerchantMenuClass $model
     * @return array
     * @throws \Throwable
     */
    public function transform(MerchantMenuClass $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}