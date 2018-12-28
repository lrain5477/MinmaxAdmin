<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\World\Models\WorldContinent;

/**
 * Class WorldContinentTransformer
 */
class WorldContinentTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  WorldContinentPresenter $presenter
     * @param  string $uri
     */
    public function __construct(WorldContinentPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  WorldContinent $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldContinent $model)
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