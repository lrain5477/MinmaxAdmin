<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\Product\Models\ProductItem;

/**
 * Class ProductItemTransformer
 */
class ProductItemTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  ProductItemPresenter $presenter
     * @param  string $uri
     */
    public function __construct(ProductItemPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  ProductItem $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ProductItem $model)
    {
        return [
            'pic' => $this->presenter->getGridThumbnail($model, 'pic'),
            'title' => $this->presenter->getGridTitle($model),
            'qty' => $this->presenter->getGridQty($model),
            'relation' => $this->presenter->getGridRelation($model),
            'updated_at' => $this->presenter->getPureString($model->updated_at->format('Y-m-d')),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}