<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\Product\Models\ProductBrand;

/**
 * Class ProductBrandTransformer
 */
class ProductBrandTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  ProductBrandPresenter $presenter
     * @param  string $uri
     */
    public function __construct(ProductBrandPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  ProductBrand $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ProductBrand $model)
    {
        return [
            'pic' => $this->presenter->getGridThumbnail($model, 'pic'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}