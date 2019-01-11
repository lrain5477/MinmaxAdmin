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
     * @var \Illuminate\Database\Eloquent\Model $model
     */
    protected $model;

    /**
     * @var array $attributes
     */
    protected $attributes = [];

    /**
     * Get table name of this model
     *
     * @return string
     */
    abstract protected function getTable();

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @param  array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Set $model to null
     */
    public function clearModel()
    {
        $this->setModel(null);
    }

    /**
     * Set $attributes to empty array
     */
    public function clearAttributes()
    {
        $this->setAttributes([]);
    }

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
        $this->clearAttributes();
        $this->clearModel();

        $this->setAttributes($attributes);

        $this->beforeCreate();

        $model = $this->serialization();

        try {
            if ($model->save()) {
                $this->setModel($model);
                $this->afterCreate();

                return $this->model;
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
        $this->clearAttributes();
        $this->clearModel();

        $this->setAttributes($attributes);
        $this->setModel($model);

        $this->beforeSave();

        $this->model->fill($this->attributes);

        if ($this->model->save()) {

            $this->afterSave();

            return $this->model;
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
        $this->clearModel();

        $this->setModel($model);

        $this->beforeDelete();

        try {
            \DB::beginTransaction();

            $deleteResult = $force ? $this->model->forceDelete() : $this->model->delete();

            if ($deleteResult) {
                $this->afterDelete();
                $this->clearModel();
                \DB::commit();
                return $deleteResult;
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
    protected function serialization($attributes = null)
    {
        $attributes = $attributes ?? $this->attributes;

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
     * In here can use or change $this->attributes
     */
    protected function beforeCreate() {}

    /**
     * Before save method
     * In here can use or change $this->attributes and $this->model
     */
    protected function beforeSave() {}

    /**
     * Before delete method
     * In here can use or change $this->model
     */
    protected function beforeDelete() {}

    /**
     * After create method
     * In here can use or change $this->attributes and $this->model
     */
    protected function afterCreate() {}

    /**
     * After save method
     * In here can use or change $this->attributes and $this->model
     */
    protected function afterSave() {}

    /**
     * After delete method
     * In here can use or change $this->model
     */
    protected function afterDelete() {}
}