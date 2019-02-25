<?php

namespace Minmax\Product\Web;

use Minmax\Base\Web\Repository;
use Minmax\Product\Models\ProductSet;

/**
 * Class ProductSetRepository
 * @property ProductSet $model
 * @method ProductSet find($id)
 * @method ProductSet one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ProductSet create($attributes)
 * @method ProductSet save($model, $attributes)
 * @method ProductSet|\Illuminate\Database\Eloquent\Builder query()
 */
class ProductSetRepository extends Repository
{
    const MODEL = ProductSet::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_set';
    }
}