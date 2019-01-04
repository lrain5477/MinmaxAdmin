<?php

namespace Minmax\Base\Web;

use Closure;

/**
 * Abstract class Repository
 */
abstract class Repository
{
    /**
     * You must set which model using.
     */
    const MODEL = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    abstract protected function getTable();

    /**
     * Search by primary key
     *
     * @param  mixed $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->query()->find($id);
    }

    /**
     * Search by condition
     *
     * @param  string|array|Closure  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function one($column = null, $operator = null, $value = null, $boolean = 'and')
    {
        $query = $this->query();

        if ($column instanceof Closure) {
            $subQuery = $this->query();

            $column($subQuery);

            return $query->addNestedWhereQuery($subQuery->getQuery(), $boolean)->first();
        } elseif (is_null($column)) {
            return $query->first();
        } else {
            return $query->where(...func_get_args())->first();
        }
    }

    /**
     * Search to a collection with condition
     *
     * @param  string|array|Closure  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function all($column = null, $operator = null, $value = null, $boolean = 'and')
    {
        $query = $this->query();

        if ($column instanceof Closure) {
            $subQuery = $this->query();

            $column($subQuery);

            return $query->addNestedWhereQuery($subQuery->getQuery(), $boolean)->get();
        } elseif (is_null($column)) {
            return $query->get();
        } else {
            return $query->where(...func_get_args())->get();
        }
    }

    /**
     * Create a new model
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function create($attributes)
    {
        $this->beforeCreate();

        $model = $this->serialization($attributes);

        try {
            if ($model->save()) {

                $this->afterCreate();

                return $model;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save($model, $attributes)
    {
        $this->beforeSave();

        $model->fill($attributes);

        if ($model->save()) {

            $this->afterSave();

            return $model;
        }

        return null;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  bool $force
     * @return bool
     */
    public function delete($model, $force = false)
    {
        $this->beforeDelete();

        try {
            \DB::beginTransaction();

            $deleteResult = $force ? $model->forceDelete() : $model->delete();

            if ($deleteResult) {

                $this->afterDelete();

                \DB::commit();
            }

            \DB::rollBack();
            return $deleteResult;
        } catch (\Exception $e) {
            \DB::rollBack();
            return false;
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
     * Serialize input attributes to a new model
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function serialization(array $attributes)
    {
        $model = static::MODEL;
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $model();

        $primaryKey = $model->incrementing ? null : uuidl();

        if (!$model->incrementing) {
            $model->setAttribute($model->getKeyName(), $primaryKey);
        }

        foreach ($attributes as $column => $value) {
            $model->setAttribute($column, $value);
        }

        return $model;
    }

    /**
     * Before create method
     */
    protected function beforeCreate() {}

    /**
     * Before save method
     */
    protected function beforeSave() {}

    /**
     * Before delete method
     */
    protected function beforeDelete() {}

    /**
     * After create method
     */
    protected function afterCreate() {}

    /**
     * After save method
     */
    protected function afterSave() {}

    /**
     * After delete method
     */
    protected function afterDelete() {}
}