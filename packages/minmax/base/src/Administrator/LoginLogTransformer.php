<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\LoginLog;

/**
 * Class LoginLogTransformer
 */
class LoginLogTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  LoginLogPresenter $presenter
     * @param  string $uri
     */
    public function __construct(LoginLogPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  LoginLog $model
     * @return array
     * @throws \Throwable
     */
    public function transform(LoginLog $model)
    {
        return [
            'guard' => $this->presenter->getGridSelection($model, 'guard'),
            'username' => $this->presenter->getGridText($model, 'username'),
            'ip' => $this->presenter->getGridText($model, 'ip'),
            'remark' => $this->presenter->getGridText($model, 'remark'),
            'result' => $this->presenter->getGridTextBadge($model, 'result'),
            'created_at' => $this->presenter->getPureString($model->created_at),
        ];
    }
}