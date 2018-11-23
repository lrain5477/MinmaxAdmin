<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Role;

/**
 * Class RoleRepository
 * @method Role find($id)
 * @method Role one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Role create($attributes)
 * @method Role save($model, $attributes)
 * @method Role|\Illuminate\Database\Eloquent\Builder query()
 */
class RoleRepository extends Repository
{
    const MODEL = Role::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'roles';
    }
}