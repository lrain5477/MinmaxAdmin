<?php

namespace App\Transformers\Administrator;

use App\Models\SystemLog;

class SystemLogTransformer extends Transformer
{
    protected $model = 'SystemLog';
    protected $parameterSet = [
        'result' => 'result',
    ];

    /**
     * @param SystemLog $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SystemLog $model)
    {
        return [
            'guard' => $this->getGridText($model->guard),
            'uri' => $this->getGridText($model->uri),
            'action' => $this->getGridText($model->action),
            'result' => $this->getGridTextBadge($model->result, 'result'),
            'username' => $this->getGridText($model->username),
            'created_at' => $this->getGridDatetime($model->created_at),
        ];
    }
}