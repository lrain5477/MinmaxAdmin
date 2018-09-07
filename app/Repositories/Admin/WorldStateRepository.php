<?php

namespace App\Repositories\Admin;

use App\Models\WorldState;

/**
 * Class WorldStateRepository
 * @method WorldState create($attributes)
 * @method WorldState save($model, $attributes)
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