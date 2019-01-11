<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\SystemLog;

/**
 * Class SystemLogRepository
 * @property SystemLog $model
 * @method SystemLog one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SystemLog create($attributes)
 * @method SystemLog save($model, $attributes)
 * @method SystemLog|\Illuminate\Database\Eloquent\Builder query()
 */
class SystemLogRepository extends Repository
{
    const MODEL = SystemLog::class;

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