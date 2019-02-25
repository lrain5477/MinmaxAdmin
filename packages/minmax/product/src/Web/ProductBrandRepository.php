<?php

namespace Minmax\Product\Web;

use Minmax\Base\Web\Repository;
use Minmax\Product\Models\ProductBrand;

/**
 * Class ProductBrandRepository
 * @property ProductBrand $model
 * @method ProductBrand find($id)
 * @method ProductBrand one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ProductBrand create($attributes)
 * @method ProductBrand save($model, $attributes)
 * @method ProductBrand|\Illuminate\Database\Eloquent\Builder query()
 */
class ProductBrandRepository extends Repository
{
    const MODEL = ProductBrand::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_brand';
    }
}