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
        $currentTimestamp  = date('Y-m-d H:i:s');
        $currentLanguageId = langId(app()->getLocale());
        $newLanguageId = $this->query()->orderByDesc('id')->first()->getKey();
        $copyQuery = <<<QUERY
insert into `language_resource`
    (`language_id`, `key`, `text`, `created_at`, `updated_at`)
select
    $newLanguageId as `language_id`, `key`, `text`, '$currentTimestamp' as `created_at`, '$currentTimestamp' as `updated_at`
from `language_resource`
where `language_id` = $currentLanguageId
QUERY;

        \DB::statement($copyQuery);

        \Cache::flush();
    }
}