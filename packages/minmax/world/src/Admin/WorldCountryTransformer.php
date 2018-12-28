<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\World\Models\WorldCountry;

/**
 * Class WorldCountryTransformer
 */
class WorldCountryTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'worldCountryShow',
        'U' => 'worldCountryEdit',
        'D' => 'worldCountryDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  WorldCountryPresenter $presenter
     * @param  string $uri
     */
    public function __construct(WorldCountryPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  WorldCountry $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldCountry $model)
    {
        return [
            'continent_id' => $this->presenter->getGridText($model->worldContinent, 'title'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'code' => $this->presenter->getGridText($model, 'code'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}