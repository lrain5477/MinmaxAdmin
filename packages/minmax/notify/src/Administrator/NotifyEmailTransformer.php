<?php

namespace Minmax\Notify\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\Notify\Models\NotifyEmail;

/**
 * Class NotifyEmailTransformer
 */
class NotifyEmailTransformer extends Transformer
{
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
            'code' => $this->presenter->getGridText($model, 'code'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'notifiable' => $this->presenter->getGridSwitch($model, 'notifiable'),
            'queueable' => $this->presenter->getGridSwitch($model, 'queueable'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}