<?php

namespace Minmax\Base\Web;

use Minmax\Base\Models\SystemParameterItem;

/**
 * Class SystemParameterItemRepository
 * @property SystemParameterItem $model
 * @method SystemParameterItem find($id)
 * @method SystemParameterItem one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SystemParameterItem create($attributes)
 * @method SystemParameterItem save($model, $attributes)
 * @method SystemParameterItem|\Illuminate\Database\Eloquent\Builder query()
 */
class SystemParameterItemRepository extends Repository
{
    const MODEL = SystemParameterItem::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'system_parameter_item';
    }
}