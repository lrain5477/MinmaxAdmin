<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\World\Models\WorldCurrency;

/**
 * Class WorldCurrencyTransformer
 */
class WorldCurrencyTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'worldCurrencyShow',
        'U' => 'worldCurrencyEdit',
        'D' => 'worldCurrencyDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  WorldCurrencyPresenter $presenter
     * @param  string $uri
     */
    public function __construct(WorldCurrencyPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  WorldCurrency $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldCurrency $model)
    {
        return [
            'title' => $this->presenter->getGridText($model, 'title'),
            'code' => $this->presenter->getGridText($model, 'code'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}