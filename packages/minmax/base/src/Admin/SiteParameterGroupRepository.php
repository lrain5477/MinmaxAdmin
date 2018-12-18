<?php

namespace Minmax\Base\Admin;

use Illuminate\Support\Facades\Cache;
use Minmax\Base\Models\SiteParameterGroup;

/**
 * Class SiteParameterGroupRepository
 * @method SiteParameterGroup find($id)
 * @method SiteParameterGroup one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SiteParameterGroup create($attributes)
 * @method SiteParameterGroup save($model, $attributes)
 * @method SiteParameterGroup|\Illuminate\Database\Eloquent\Builder query()
 */
class SiteParameterGroupRepository extends Repository
{
    const MODEL = SiteParameterGroup::class;

    const UPDATED_AT = null;

    protected $languageColumns = ['title'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'site_parameter_group';
    }

    public function getSelectParameters($editable = false)
    {
        if ($editable) {
            $model = $this->all('editable', true);
        } else {
            $model = $this->all();
        }
        return $model
            ->mapWithKeys(function ($groupItem) {
                /** @var SiteParameterGroup $groupItem */
                return [$groupItem->id => ['title' => $groupItem->title, 'options' => $groupItem->options]];
            })
            ->toArray();
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