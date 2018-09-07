<?php

namespace App\Repositories\Admin;

use App\Models\WorldCountry;

/**
 * Class WorldCountryRepository
 * @method WorldCountry create($attributes)
 * @method WorldCountry save($model, $attributes)
 */
class WorldCountryRepository extends Repository
{
    const MODEL = WorldCountry::class;
    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_country';
    }
}