<?php

namespace App\Repositories\Admin;

use Closure;

/**
 * Abstract class Repository
 */
abstract class Repository
{
    const MODEL = null;

    /**
     * Search by primary key
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->query()->findOrFail($id);
    }

    public function all($column, $operator = null, $value = null, $boolean = 'and')
    {
        if ($column instanceof Closure) {
            $query = $this->query();

            $column($query);

            return $query->addNestedWhereQuery($query->getQuery(), $boolean)->get();
        } else {
            return $this->query()->where(...func_get_args())->get();
        }
    }

    /**
     * Create a model query builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return call_user_func(static::MODEL.'::query');
    }

    /**
     * Set attributes into model entity
     *
     * @param array $attributes
     * @return mixed
     */
    abstract protected function serialization(array $attributes);
}