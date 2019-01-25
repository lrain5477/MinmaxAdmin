<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\Product\Models\ProductCategory;

/**
 * Class ProductCategoryTransformer
 */
class ProductCategoryTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'productCategoryShow',
        'U' => 'productCategoryEdit',
        'D' => 'productCategoryDestroy',
    ];

    protected $menuList;

    /**
     * Transformer constructor. Put action permissions.
     * @param  ProductCategoryPresenter $presenter
     * @param  string $uri
     */
    public function __construct(ProductCategoryPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        $this->menuList = (new ProductCategoryRepository)->all();

        parent::__construct($uri);
    }

    /**
     * @param  ProductCategory $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ProductCategory $model)
    {
        $loopLevel = 0;
        $loopModel = $model;
        do {
            $childrenFlag = ++$loopLevel < config('app.ecommerce_layer_limit', 3);
            if ($loopModel->parent_id) { $loopModel = $this->menuList->firstWhere('id', $loopModel->parent_id); } else { break; }
        } while ($childrenFlag);

        return [
            'title' => $this->presenter->getGridText($model, 'title'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model, $childrenFlag
                ? [
                    ['permission' => 'R', 'view' => 'MinmaxProduct::admin.product-category.action-button-children']
                ]
                : []
            ),
        ];
    }
}