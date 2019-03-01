<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Repository;
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

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['title', 'details'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_brand';
    }

    /**
     * @return array
     */
    public function getSelectParameters()
    {
        return $this->all(...func_get_args())
            ->sortBy('sort')
            ->mapWithKeys(function($item) {
                /** @var ProductBrand $item */
                return [$item->id => ['title' => $item->title, 'options' => null]];
            })
            ->toArray();
    }
}