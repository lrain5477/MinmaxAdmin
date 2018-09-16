<?php

namespace App\Repositories\Administrator;

use App\Models\WorldLanguage;

/**
 * Class WorldLanguageRepository
 * @method WorldLanguage find($id)
 * @method WorldLanguage one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldLanguage create($attributes)
 * @method WorldLanguage save($model, $attributes)
 * @method WorldLanguage|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldLanguageRepository extends Repository
{
    const MODEL = WorldLanguage::class;
    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_language';
    }

    protected function beforeCreate()
    {
        \Cache::forget('langId');
    }

    protected function afterCreate()
    {

    }
}