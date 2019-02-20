<?php

namespace Minmax\Ad\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\Ad\Models\AdvertisingCategory;

/**
 * Class AdvertisingCategoryTransformer
 */
class AdvertisingCategoryTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  AdvertisingCategoryPresenter $presenter
     * @param  string $uri
     */
    public function __construct(AdvertisingCategoryPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  AdvertisingCategory $model
     * @return array
     * @throws \Throwable
     */
    public function transform(AdvertisingCategory $model)
    {
        return [
            'code' => $this->presenter->getGridText($model, 'code'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'ad_type' => $this->presenter->getGridSelection($model, 'ad_type'),
            'amount' => $this->presenter->getGridAmount($model),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}