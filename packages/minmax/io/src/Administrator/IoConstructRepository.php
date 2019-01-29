<?php

namespace Minmax\Io\Administrator;

use Minmax\Base\Administrator\Repository;
use Minmax\Io\Models\IoConstruct;

/**
 * Class IoConstructRepository
 * @property IoConstruct $model
 * @method IoConstruct find($id)
 * @method IoConstruct one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method IoConstruct create($attributes)
 * @method IoConstruct save($model, $attributes)
 * @method IoConstruct|\Illuminate\Database\Eloquent\Builder query()
 */
class IoConstructRepository extends Repository
{
    const MODEL = IoConstruct::class;

    protected $sort = 'sort';

    protected $sorting = true;

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