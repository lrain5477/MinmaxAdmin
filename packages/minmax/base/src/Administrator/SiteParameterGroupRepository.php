<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\SiteParameterGroup;

/**
 * Class SiteParameterGroupRepository
 * @property SiteParameterGroup $model
 * @method SiteParameterGroup find($id)
 * @method SiteParameterGroup one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SiteParameterGroup create($attributes)
 * @method SiteParameterGroup save($model, $attributes)
 * @method SiteParameterGroup|\Illuminate\Database\Eloquent\Builder query()
 */
class SiteParameterGroupRepository extends Repository
{
    const MODEL = SiteParameterGroup::class;

    protected $languageColumns = ['title'];

    const UPDATED_AT = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'site_parameter_group';
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

    public function getSelectParameters()
    {
        return $this->all()
            ->mapWithKeys(function ($item) {
                /** @var SiteParameterGroup $item */
                return [$item->id => ['title' => $item->title, 'options' => $item->options]];
            })
            ->toArray();
    }
}