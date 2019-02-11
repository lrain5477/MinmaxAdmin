<?php

namespace Minmax\Base\Administrator;

use Illuminate\Support\Facades\DB;
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

    protected $sorting = true;

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

    protected function getSortWhere()
    {
        return "table_name = '{$this->model->table_name}' and column_name = '{$this->model->column_name}'";
    }

    public function getTables()
    {
        return DB::table($this->getTable())
            ->groupBy('table_name')
            ->pluck('table_name', 'table_name')
            ->map(function ($item) {
                return ['title' => $item, 'options' => []];
            })
            ->toArray();
    }

    public function getFields($table, $column)
    {
        return $this->query()
            ->where(['table_name' => $table, 'column_name' => $column, 'active' => true])
            ->orderBy('sort')
            ->get();
    }
}