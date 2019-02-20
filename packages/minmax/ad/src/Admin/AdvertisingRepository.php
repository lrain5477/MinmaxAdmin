<?php

namespace Minmax\Ad\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Ad\Models\Advertising;

/**
 * Class AdvertisingRepository
 * @property Advertising $model
 * @method Advertising find($id)
 * @method Advertising one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Advertising create($attributes)
 * @method Advertising save($model, $attributes)
 * @method Advertising|\Illuminate\Database\Eloquent\Builder query()
 */
class AdvertisingRepository extends Repository
{
    const MODEL = Advertising::class;

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['title', 'link', 'details'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'advertising';
    }

    protected function getSortWhere()
    {
        return "category_id = '{$this->model->category_id}'";
    }
}