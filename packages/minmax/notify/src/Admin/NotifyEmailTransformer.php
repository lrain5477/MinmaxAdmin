<?php

namespace Minmax\Notify\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\Notify\Models\NotifyEmail;

/**
 * Class NotifyEmailTransformer
 */
class NotifyEmailTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'memberShow',
        'U' => 'memberEdit',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  NotifyEmailPresenter $presenter
     * @param  string $uri
     */
    public function __construct(NotifyEmailPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  NotifyEmail $model
     * @return array
     * @throws \Throwable
     */
    public function transform(NotifyEmail $model)
    {
        return [
            'sort' => $this->presenter->getGridText($model, 'sort'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}