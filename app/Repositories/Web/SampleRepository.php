<?php

namespace App\Repositories\Web;

use App\Models\PasswordReset;
use Minmax\Base\Web\Repository;

/**
 * Class SampleRepository
 * @property PasswordReset $model
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