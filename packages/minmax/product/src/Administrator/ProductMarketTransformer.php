<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\Product\Models\ProductMarket;

/**
 * Class ProductMarketTransformer
 */
class ProductMarketTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  ProductMarketPresenter $presenter
     * @param  string $uri
     */
    public function __construct(ProductMarketPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  ProductMarket $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ProductMarket $model)
    {
        return [
            'code' => $this->presenter->getGridText($model, 'code'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'admin_id' => $this->presenter->getGridSelection($model, 'admin_id'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}