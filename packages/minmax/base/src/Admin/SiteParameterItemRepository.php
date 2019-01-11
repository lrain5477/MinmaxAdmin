<?php

namespace Minmax\Base\Admin;

use Illuminate\Support\Facades\Cache;
use Minmax\Base\Models\SiteParameterItem;

/**
 * Class SiteParameterItemRepository
 * @property SiteParameterItem $model
 * @method SiteParameterItem find($id)
 * @method SiteParameterItem one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SiteParameterItem create($attributes)
 * @method SiteParameterItem save($model, $attributes)
 * @method SiteParameterItem|\Illuminate\Database\Eloquent\Builder query()
 */
class SiteParameterItemRepository extends Repository
{
    const MODEL = SiteParameterItem::class;

    const UPDATED_AT = null;

    protected $hasSort = true;

    protected $languageColumns = ['label'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'site_parameter_item';
    }

    protected function afterCreate()
    {
        foreach ((new WorldLanguageRepository())->all() as $language) {
            Cache::forget("siteParams.{$language->code}");
        }
    }

    protected function afterSave()
    {
        foreach ((new WorldLanguageRepository())->all() as $language) {
            Cache::forget("siteParams.{$language->code}");
        }
    }

    protected function afterDelete()
    {
        foreach ((new WorldLanguageRepository())->all() as $language) {
            Cache::forget("siteParams.{$language->code}");
        }
    }
}