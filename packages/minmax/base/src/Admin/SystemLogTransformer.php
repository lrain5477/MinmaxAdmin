<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\SystemLog;

/**
 * Class SystemLogTransformer
 */
class SystemLogTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'systemLogShow',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  SystemLogPresenter $presenter
     * @param  string $uri
     */
    public function __construct(SystemLogPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  SystemLog $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SystemLog $model)
    {
        return [
            'uri' => $this->presenter->getGridText($model, 'uri'),
            'id' => $this->presenter->getGridText($model, 'id'),
            'username' => $this->presenter->getGridText($model, 'username'),
            'ip' => $this->presenter->getGridText($model, 'ip'),
            'remark' => $this->presenter->getGridText($model, 'remark'),
            'result' => $this->presenter->getGridTextBadge($model, 'result'),
            'created_at' => $this->presenter->getPureString($model->created_at),
        ];
    }
}
