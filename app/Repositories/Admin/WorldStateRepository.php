<?php

namespace App\Repositories\Admin;

use App\Models\WorldState;

/**
 * Class WorldStateRepository
 * @method WorldState find($id)
 * @method WorldState one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldState create($attributes)
 * @method WorldState save($model, $attributes)
 * @method WorldState|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldStateRepository extends Repository
{
    const MODEL = WorldState::class;
    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_state';
    }
}