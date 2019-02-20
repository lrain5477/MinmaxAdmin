<?php

namespace Minmax\Ad\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\Ad\Models\Advertising;

/**
 * Class AdvertisingTransformer
 */
class AdvertisingTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'advertisingShow',
        'U' => 'advertisingEdit',
        'D' => 'advertisingDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  AdvertisingPresenter $presenter
     * @param  string $uri
     */
    public function __construct(AdvertisingPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  Advertising $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Advertising $model)
    {
        return [
            'id' => $this->presenter->getGridCheckBox($model),
            'category_id' => $this->presenter->getGridTitle($model),
            'count' => $this->presenter->getGridCount($model),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'start_at' => $this->presenter->getPureString($model->start_at->format('Y-m-d')),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}