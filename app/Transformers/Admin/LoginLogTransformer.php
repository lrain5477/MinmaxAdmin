<?php

namespace App\Transformers\Admin;

use App\Models\LoginLog;

class LoginLogTransformer extends Transformer
{
    protected $model = 'LoginLog';
    protected $parameterSet = [
        'result' => 'result',
    ];

    /**
     * @param LoginLog $model
     * @return array
     * @throws \Throwable
     */
    public function transform(LoginLog $model)
    {
        return [
            'username' => $this->getGridText($model->username),
            'ip' => $this->getGridText($model->ip),
            'result' => $this->getGridTextBadge($model->getAttribute('result'), 'result'),
            'created_at' => $this->getGridDatetime($model->created_at),
        ];
    }
}