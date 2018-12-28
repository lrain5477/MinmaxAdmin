<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\LoginLog;

/**
 * Class LoginLogRepository
 * @method LoginLog one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method LoginLog create($attributes)
 * @method LoginLog save($model, $attributes)
 * @method LoginLog|\Illuminate\Database\Eloquent\Builder query()
 */
class LoginLogRepository extends Repository
{
    const MODEL = LoginLog::class;

    const UPDATED_AT = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'login_log';
    }

    public function find($id)
    {
        return null;
    }
}