<?php

namespace App\Repositories\Admin;

use App\Models\Admin;

/**
 * Class AdminRepository
 * @method Admin find($id)
 * @method Admin one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Admin create($attributes)
 * @method Admin save($model, $attributes)
 * @method Admin|\Illuminate\Database\Eloquent\Builder query()
 */
class AdminRepository extends Repository
{
    const MODEL = Admin::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'admin';
    }
}