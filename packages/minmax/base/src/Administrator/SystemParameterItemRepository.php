<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\SystemParameterItem;

/**
 * Class SystemParameterItemRepository
 * @method SystemParameterItem find($id)
 * @method SystemParameterItem one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SystemParameterItem create($attributes)
 * @method SystemParameterItem save($model, $attributes)
 * @method SystemParameterItem|\Illuminate\Database\Eloquent\Builder query()
 */
class SystemParameterItemRepository extends Repository
{
    const MODEL = SystemParameterItem::class;

    protected $hasSort = true;

    protected $languageColumns = ['label'];

    const UPDATED_AT = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'system_parameter_item';
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
}