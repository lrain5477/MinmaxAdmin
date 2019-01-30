<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\Product\Models\ProductSet;

/**
 * Class ProductSetTransformer
 */
class ProductSetTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'productSetShow',
        'U' => 'productSetEdit',
        'D' => 'productSetDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  ProductSetPresenter $presenter
     * @param  string $uri
     */
    public function __construct(ProductSetPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  ProductSet $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ProductSet $model)
    {
        return [
            'pic' => $this->presenter->getGridThumbnail($model, 'pic'),
            'title' => $this->presenter->getGridTitle($model),
            'price' => $model->price('sell', null, null, true) ?? '-',
            'relation' => $this->presenter->getGridRelation($model),
            'updated_at' => $this->presenter->getPureString($model->updated_at->format('Y-m-d')),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}