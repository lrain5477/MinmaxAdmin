<?php

namespace App\Transformers\Admin;

use App\Models\LoginLog;

class LoginLogTransformer extends Transformer
{
    protected $model = 'LoginLog';

    /**
     * @param LoginLog $model
     * @return array
     * @throws \Throwable
     */
    public function transform(LoginLog $model)
    {
        $classResult = [
            '1' => 'badge-danger',
            '0' => 'badge-warning'
        ];

        return [
            'username' => $this->getGridText($model->username),
            'ip' => $this->getGridText($model->ip),
            'result' => $this->getGridTextBadge($model->getAttribute('result'), $classResult[$model->getAttribute('result')], 'result'),
            'created_at' => $this->getGridDatetime($model->created_at),
        ];
    }
}