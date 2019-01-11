<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\World\Models\WorldCity;

/**
 * Class WorldCityRepository
 * @property WorldCity $model
 * @method WorldCity find($id)
 * @method WorldCity one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldCity create($attributes)
 * @method WorldCity save($model, $attributes)
 * @method WorldCity|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldCityRepository extends Repository
{
    const MODEL = WorldCity::class;

    protected $hasSort = true;

    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_city';
    }
}