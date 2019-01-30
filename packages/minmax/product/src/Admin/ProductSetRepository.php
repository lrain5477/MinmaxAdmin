<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Repository;
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

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['title', 'details', 'seo'];

    protected $categories = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_set';
    }

    protected function beforeCreate()
    {
        $this->categories = array_pull($this->attributes, 'categories', []);
    }

    protected function afterCreate()
    {
        $this->model->productCategories()->sync($this->categories);
        $this->categories = null;
    }

    protected function beforeSave()
    {
        if (count($this->attributes) > 1 || !array_key_exists('sort', $this->attributes)) {
            $this->categories = array_pull($this->attributes, 'categories', []) ?? [];
        }
    }

    protected function afterSave()
    {
        if (! is_null($this->categories)) {
            $this->model->productCategories()->sync($this->categories);
            $this->categories = null;
        }
    }
}