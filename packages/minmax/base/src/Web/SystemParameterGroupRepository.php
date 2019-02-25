<?php

namespace Minmax\Base\Web;

use Minmax\Base\Models\SystemParameterGroup;

/**
 * Class SystemParameterGroupRepository
 * @property SystemParameterGroup $model
 * @method SystemParameterGroup find($id)
 * @method SystemParameterGroup one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SystemParameterGroup create($attributes)
 * @method SystemParameterGroup save($model, $attributes)
 * @method SystemParameterGroup|\Illuminate\Database\Eloquent\Builder query()
 */
class SystemParameterGroupRepository extends Repository
{
    const MODEL = SystemParameterGroup::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'system_parameter_group';
    }
}