<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\SystemParameterGroup;

/**
 * Class SystemParameterGroupRepository
 * @method SystemParameterGroup find($id)
 * @method SystemParameterGroup one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SystemParameterGroup create($attributes)
 * @method SystemParameterGroup save($model, $attributes)
 * @method SystemParameterGroup|\Illuminate\Database\Eloquent\Builder query()
 */
class SystemParameterGroupRepository extends Repository
{
    const MODEL = SystemParameterGroup::class;

    protected $languageColumns = ['title'];

    const UPDATED_AT = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'system_parameter_group';
    }

    protected function afterCreate()
    {
        try {
            foreach ((new WorldLanguageRepository)->all() as $language) {
                cache()->forget('systemParams.' . $language->code);
            }
        } catch (\Exception $e) {}
    }

    protected function afterSave()
    {
        try {
            foreach ((new WorldLanguageRepository)->all() as $language) {
                cache()->forget('systemParams.' . $language->code);
            }
        } catch (\Exception $e) {}
    }

    protected function afterDelete()
    {
        try {
            foreach ((new WorldLanguageRepository)->all() as $language) {
                cache()->forget('systemParams.' . $language->code);
            }
        } catch (\Exception $e) {}
    }

    public function getSelectParameters()
    {
        return $this->all()
            ->mapWithKeys(function ($item) {
                /** @var SystemParameterGroup $item */
                return [$item->id => ['title' => $item->title, 'options' => $item->options]];
            })
            ->toArray();
    }
}