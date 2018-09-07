<?php

namespace App\Repositories\Admin;

use App\Models\WebData;

/**
 * Class WebDataRepository
 * @method WebData create($attributes)
 * @method WebData save($model, $attributes)
 */
class WebDataRepository extends Repository
{
    const MODEL = WebData::class;
    protected $languageColumns = ['company', 'contact', 'seo', 'offline_text'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'web_data';
    }
}