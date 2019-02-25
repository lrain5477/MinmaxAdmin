<?php

namespace Minmax\Product\Web;

use Minmax\Base\Web\Repository;
use Minmax\Product\Models\ProductMarket;

/**
 * Class ProductMarketRepository
 * @property ProductMarket $model
 * @method ProductMarket find($id)
 * @method ProductMarket one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ProductMarket create($attributes)
 * @method ProductMarket save($model, $attributes)
 * @method ProductMarket|\Illuminate\Database\Eloquent\Builder query()
 */
class ProductMarketRepository extends Repository
{
    const MODEL = ProductMarket::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_market';
    }
}