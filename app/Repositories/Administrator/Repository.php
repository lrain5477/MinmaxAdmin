<?php

namespace App\Repositories\Administrator;

use Closure;

/**
 * Abstract class Repository
 */
abstract class Repository
{
    const MODEL = null;

    protected $languageColumns = [];
    protected $languageBuffer = [];

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
        return $this->query()->findOrFail($id);
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
                $model = $this->saveLanguage($model);

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

        $this->clearLanguageBuffer();

        foreach ($this->languageColumns as $column) {
            if (array_key_exists($column, $attributes)) {
                $attributes[$column] = $this->exchangeLanguage($attributes, $column, $model->getAttribute($model->getKeyName()));
            }
        }

        if (count($this->languageBuffer) > 0) {
            $attributes['updated_at'] = date('Y-m-d H:i:s');
        }

        $model->fill($attributes);

        if ($model->save()) {
            $model = $this->saveLanguage($model);
            return $model;
        }

        $this->afterSave();

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

            $this->deleteLanguage($model);

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
    protected function serialization(array $attributes)
    {
        $this->clearLanguageBuffer();

        $model = static::MODEL;
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $model();

        $primaryKey = $model->incrementing ? null : uuidl();

        if (!$model->incrementing) {
            $model->setAttribute($model->getKeyName(), $primaryKey);
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