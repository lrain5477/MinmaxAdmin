<?php

namespace App\Repositories\Admin;

use App\Models\WorldCountry;

/**
 * Class WorldCountryRepository
 * @method WorldCountry find($id)
 * @method WorldCountry one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldCountry create($attributes)
 * @method WorldCountry save($model, $attributes)
 * @method WorldCountry|\Illuminate\Database\Eloquent\Builder query()
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