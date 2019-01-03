<?php

namespace Minmax\Io\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Io\Models\IoConstruct;

/**
 * Class IoConstructRepository
 * @method IoConstruct find($id)
 * @method IoConstruct one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method IoConstruct create($attributes)
 * @method IoConstruct save($model, $attributes)
 * @method IoConstruct|\Illuminate\Database\Eloquent\Builder query()
 */
class IoConstructRepository extends Repository
{
    const MODEL = IoConstruct::class;

    protected $hasSort = true;

    protected $languageColumns = ['title', 'filename'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'io_construct';
    }
}