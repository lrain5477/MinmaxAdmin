<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\World\Models\WorldContinent;

/**
 * Class WorldContinentRepository
 * @method WorldContinent find($id)
 * @method WorldContinent one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldContinent create($attributes)
 * @method WorldContinent save($model, $attributes)
 * @method WorldContinent|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldContinentRepository extends Repository
{
    const MODEL = WorldContinent::class;

    protected $hasSort = true;

    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_continent';
    }
}