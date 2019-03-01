<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\Product\Models\ProductPackage;

/**
 * Class ProductPackageTransformer
 */
class ProductPackageTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  ProductPackagePresenter $presenter
     * @param  string $uri
     */
    public function __construct(ProductPackagePresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  ProductPackage $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ProductPackage $model)
    {
        $currency = getCurrency(null, app()->getLocale());
        $prefix = getCurrency('symbol', app()->getLocale());

        return [
            'pic' => $this->presenter->getGridThumbnail($model->productSet, 'pic'),
            'set_sku' => $this->presenter->getGridTitle($model),
            'start_at' => $this->presenter->getGridText($model, 'start_at'),
            'price_sell' => $this->presenter->getPureString($prefix . ' ' . array_get($model->price_sell, $currency)),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}