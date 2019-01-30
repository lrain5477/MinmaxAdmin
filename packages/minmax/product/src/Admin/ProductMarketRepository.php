<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Repository;
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
        return 'product_market';
    }

    /**
     * @return array
     */
    public function getSelectParameters()
    {
        return $this->query()
            ->orderBy('sort')
            ->get()
            ->mapWithKeys(function($item) {
                /** @var \Minmax\Product\Models\ProductMarket $item */
                return [$item->id => ['title' => $item->title, 'options' => $item->options]];
            })
            ->toArray();
    }
}