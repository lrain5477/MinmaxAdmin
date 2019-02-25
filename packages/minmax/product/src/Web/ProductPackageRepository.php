<?php

namespace Minmax\Product\Web;

use Minmax\Base\Web\Repository;
use Minmax\Product\Models\ProductPackage;

/**
 * Class ProductPackageRepository
 * @property ProductPackage $model
 * @method ProductPackage find($id)
 * @method ProductPackage one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ProductPackage create($attributes)
 * @method ProductPackage save($model, $attributes)
 * @method ProductPackage|\Illuminate\Database\Eloquent\Builder query()
 */
class ProductPackageRepository extends Repository
{
    const MODEL = ProductPackage::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_package';
    }
}