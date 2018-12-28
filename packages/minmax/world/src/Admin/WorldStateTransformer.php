<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\World\Models\WorldState;

/**
 * Class WorldStateTransformer
 */
class WorldStateTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'worldStateShow',
        'U' => 'worldStateEdit',
        'D' => 'worldStateDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  WorldStatePresenter $presenter
     * @param  string $uri
     */
    public function __construct(WorldStatePresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  WorldState $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldState $model)
    {
        return [
            'country_id' => $this->presenter->getGridText($model->worldCountry, 'title'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'code' => $this->presenter->getGridText($model, 'code'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}