<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\World\Models\WorldCounty;

/**
 * Class WorldCountyTransformer
 */
class WorldCountyTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  WorldCountyPresenter $presenter
     * @param  string $uri
     */
    public function __construct(WorldCountyPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  WorldCounty $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldCounty $model)
    {
        return [
            'state_id' => $this->presenter->getGridText($model->worldState, 'title'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'code' => $this->presenter->getGridText($model, 'code'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}