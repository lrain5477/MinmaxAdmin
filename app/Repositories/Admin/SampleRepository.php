<?php

namespace App\Repositories\Admin;

use App\Models\PasswordReset;
use Minmax\Base\Admin\Repository;

/**
 * Class SampleRepository
 * @method PasswordReset find($id)
 * @method PasswordReset one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method PasswordReset create($attributes)
 * @method PasswordReset save($model, $attributes)
 * @method PasswordReset|\Illuminate\Database\Eloquent\Builder query()
 */
class SampleRepository extends Repository
{
    const MODEL = PasswordReset::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'password_reset';
    }
}