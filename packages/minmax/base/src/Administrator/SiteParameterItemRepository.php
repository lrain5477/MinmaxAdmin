<?php

namespace Minmax\Base\Administrator;

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

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['label', 'details'];

    const UPDATED_AT = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'site_parameter_item';
    }

    protected function getSortWhere()
    {
        return "group_id = '{$this->model->group_id}'";
    }

    protected function afterCreate()
    {
        try {
            foreach ((new WorldLanguageRepository)->all() as $language) {
                cache()->forget('siteParams.' . $language->code);
            }
        } catch (\Exception $e) {}
    }

    protected function afterSave()
    {
        try {
            foreach ((new WorldLanguageRepository)->all() as $language) {
                cache()->forget('siteParams.' . $language->code);
            }
        } catch (\Exception $e) {}
    }

    protected function afterDelete()
    {
        try {
            foreach ((new WorldLanguageRepository)->all() as $language) {
                cache()->forget('siteParams.' . $language->code);
            }
        } catch (\Exception $e) {}
    }
}