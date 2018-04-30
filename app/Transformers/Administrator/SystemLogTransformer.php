<?php

namespace App\Transformers\Administrator;

use App\Models\SystemLog;

class SystemLogTransformer extends Transformer
{
    protected $uri = 'system-log';
    protected $model = 'SystemLog';

    /**
     * @param SystemLog $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SystemLog $model)
    {
        $classResult = [
            '1' => 'badge-danger',
            '0' => 'badge-warning'
        ];

        return [
            'guard' => $this->getGridText($model->guard),
            'uri' => $this->getGridText($model->uri),
            'action' => $this->getGridText($model->action),
            'result' => $this->getGridTextBadge($model->result, $classResult[$model->result], 'result'),
            'username' => $this->getGridText($model->username),
            'created_at' => $this->getGridDatetime($model->created_at),
        ];
    }
}