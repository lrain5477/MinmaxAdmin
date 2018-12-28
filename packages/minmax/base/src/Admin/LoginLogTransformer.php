<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\LoginLog;

/**
 * Class LoginLogTransformer
 */
class LoginLogTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'loginLogShow',
    ];

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
            'username' => $this->presenter->getGridText($model, 'username'),
            'ip' => $this->presenter->getGridText($model, 'ip'),
            'remark' => $this->presenter->getGridText($model, 'remark'),
            'result' => $this->presenter->getGridTextBadge($model, 'result'),
            'created_at' => $this->presenter->getPureString($model->created_at),
        ];
    }
}
