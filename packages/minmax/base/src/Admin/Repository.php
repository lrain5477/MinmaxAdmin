<?php

namespace Minmax\Base\Admin;

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
     * If doesn't have update timestamp column, please set null.
     */
    const UPDATED_AT = 'updated_at';

    /**
     * @var bool $hasSort
     */
    protected $hasSort = false;

    /**
     * @var array $languageColumns
     */
    protected $languageColumns = [];

    /**
     * @var array $languageBuffer
     */
    protected $languageBuffer = [];

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
                $model = $this->saveLanguage($model);
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
        $this->clearLanguageBuffer();

        $this->setAttributes($attributes);
        $this->setModel($model);

        $this->beforeSave();

        foreach ($this->languageColumns as $column) {
            if (array_key_exists($column, $this->attributes)) {
                $this->attributes[$column] = $this->exchangeLanguage($this->attributes, $column, $this->model->getAttribute($this->model->getKeyName()));
            }
        }

        if (count($this->languageBuffer) > 0 && !is_null(static::UPDATED_AT)) {
            $this->attributes[static::UPDATED_AT] = date('Y-m-d H:i:s');
        }

        $this->model->fill($this->attributes);

        if ($this->model->save()) {
            $model = $this->saveLanguage($this->model);
            $this->setModel($model);
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

            if (! (method_exists($this->model, 'trashed') && $this->model->trashed())) {
                $this->deleteLanguage($this->model);
            }

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
     * Clear valuable $languageBuffer to empty array
     *
     * @return void
     */
    protected function clearLanguageBuffer()
    {
        $this->languageBuffer = [];
    }

    /**
     * Save value to buffer array and return a language map key
     *
     * @param  array $attributes
     * @param  string $column
     * @param  string|null $id
     * @return string
     */
    protected function exchangeLanguage($attributes, $column, $id = null)
    {
        if(!array_key_exists($column, $attributes)) return null;

        $attribute = $attributes[$column];

        if (!array_key_exists($column, $this->languageBuffer)) {
            $this->languageBuffer[$column] = $attribute;

            if ($id) {
                $attribute = "{$this->getTable()}.{$column}.{$id}";
            } else {
                $attribute = "{$this->getTable()}.{$column}";
            }
        }

        return $attribute;
    }

    /**
     * Save language value from buffer array to database and after return model
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string|array $columns
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function saveLanguage($model, $columns = [])
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }

        if (count($this->languageBuffer) > 0) {
            foreach ($this->languageBuffer as $column => $value) {
                if (count($columns) > 0 && !in_array($column, $columns)) continue;

                $key = "{$this->getTable()}.{$column}.{$model->getKey()}";
                $model->setAttribute($column, $key);
                saveLang($key, $value);
            }
            $model->save();
        }

        return $model;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    protected function deleteLanguage($model)
    {
        $keyList = [];

        foreach ($this->languageColumns as $column) {
            $keyList[] = "{$this->getTable()}.{$column}.{$model->getKey()}";
        }

        if (count($keyList) > 0) {
            if (deleteLang($keyList)) {
                return true;
            }
            return false;
        }

        return true;
    }

    /**
     * Serialize input attributes to a new model
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function serialization($attributes = null)
    {
        $this->clearLanguageBuffer();

        $attributes = $attributes ?? $this->attributes;

        $model = static::MODEL;
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $model();

        $primaryKey = $model->incrementing ? null : uuidl();

        if (!$model->incrementing) {
            $model->setAttribute($model->getKeyName(), $primaryKey);
        }

        if ($this->hasSort && array_key_exists('sort', $attributes)) {
            if (is_null($attributes['sort']) || $attributes['sort'] < 1) {
                $attributes['sort'] = 1;
            }
        }

        foreach ($attributes as $column => $value) {
            if (in_array($column, $this->languageColumns)) {
                $model->setAttribute($column, $this->exchangeLanguage($attributes, $column, $primaryKey));
            } else {
                $model->setAttribute($column, $value);
            }
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