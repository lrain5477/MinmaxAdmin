<?php

namespace Minmax\Product\Web;

use Minmax\Base\Web\Repository;
use Minmax\Product\Models\ProductCategory;

/**
 * Class ProductCategoryRepository
 * @property ProductCategory $model
 * @method ProductCategory find($id)
 * @method ProductCategory one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ProductCategory create($attributes)
 * @method ProductCategory save($model, $attributes)
 * @method ProductCategory|\Illuminate\Database\Eloquent\Builder query()
 */
class ProductCategoryRepository extends Repository
{
    const MODEL = ProductCategory::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_category';
    }
}