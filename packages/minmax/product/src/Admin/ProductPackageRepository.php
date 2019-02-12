<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Repository;
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

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['description'];

    protected $markets = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_package';
    }

    protected function getSortWhere()
    {
        return "set_sku = '{$this->model->set_sku}'";
    }

    protected function beforeCreate()
    {
        $this->markets = array_pull($this->attributes, 'productMarkets', []);
    }

    protected function afterCreate()
    {
        $this->model->productMarkets()->sync($this->markets);
        $this->markets = null;
    }

    protected function beforeSave()
    {
        if (count($this->attributes) > 1 || !array_key_exists('sort', $this->attributes)) {
            $this->markets = array_pull($this->attributes, 'productMarkets', []) ?? [];
        }
    }

    protected function afterSave()
    {
        if (! is_null($this->markets)) {
            $this->model->productMarkets()->sync($this->markets);
            $this->markets = null;
        }
    }
}