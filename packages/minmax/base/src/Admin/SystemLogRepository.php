<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\SystemLog;

/**
 * Class SystemLogRepository
 * @method SystemLog one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SystemLog create($attributes)
 * @method SystemLog saveLanguage($model)
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
        return 'system_log';
    }

    public function find($id)
    {
        return null;
    }
}