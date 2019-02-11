<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\ColumnExtension;

/**
 * Class ColumnExtensionRepository
 * @property ColumnExtension $model
 * @method ColumnExtension find($id)
 * @method ColumnExtension one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ColumnExtension create($attributes)
 * @method ColumnExtension save($model, $attributes)
 * @method ColumnExtension|\Illuminate\Database\Eloquent\Builder query()
 */
class ColumnExtensionRepository extends Repository
{
    const MODEL = ColumnExtension::class;

    protected $sort = 'sort';

    protected $languageColumns = ['title'];

    const UPDATED_AT = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'column_extension';
    }

    public function getFields($table, $column)
    {
        return $this->query()
            ->where(['table_name' => $table, 'column_name' => $column, 'active' => true])
            ->orderBy('sort')
            ->get();
    }
}