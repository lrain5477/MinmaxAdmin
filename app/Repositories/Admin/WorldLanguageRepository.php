<?php

namespace App\Repositories\Admin;

use App\Models\WorldLanguage;

/**
 * Class WorldLanguageRepository
 * @method WorldLanguage create($attributes)
 * @method WorldLanguage save($model, $attributes)
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
}