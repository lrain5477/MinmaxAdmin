<?php

namespace Minmax\Product\Web;

use Minmax\Base\Web\Repository;
use Minmax\Product\Models\ProductItem;

/**
 * Class ProductItemRepository
 * @property ProductItem $model
 * @method ProductItem find($id)
 * @method ProductItem one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ProductItem create($attributes)
 * @method ProductItem save($model, $attributes)
 * @method ProductItem|\Illuminate\Database\Eloquent\Builder query()
 */
class ProductItemRepository extends Repository
{
    const MODEL = ProductItem::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_item';
    }
}