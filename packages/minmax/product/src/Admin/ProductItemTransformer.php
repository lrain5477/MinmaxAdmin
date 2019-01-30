<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\Product\Models\ProductItem;

/**
 * Class ProductItemTransformer
 */
class ProductItemTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'productItemShow',
        'U' => 'productItemEdit',
        'D' => 'productItemDestroy',
    ];

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
            'qty' => $this->presenter->getGridText($model, 'qty'),
            'updated_at' => $this->presenter->getGridText($model, 'updated_at'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}