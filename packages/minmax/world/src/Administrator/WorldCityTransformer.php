<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\World\Models\WorldCity;

/**
 * Class WorldCityTransformer
 */
class WorldCityTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  WorldCityPresenter $presenter
     * @param  string $uri
     */
    public function __construct(WorldCityPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  WorldCity $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldCity $model)
    {
        return [
            'county_id' => $this->presenter->getGridText($model->worldCounty, 'title'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'code' => $this->presenter->getGridText($model, 'code'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}