<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\Administrator;

/**
 * Class AdministratorRepository
 * @method Administrator find($id)
 * @method Administrator one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Administrator|\Illuminate\Database\Eloquent\Builder query()
 * @method Administrator saveLanguage($model, $columns = [])
 */
class AdministratorRepository extends Repository
{
    const MODEL = Administrator::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'administrator';
    }

    /**
     * @param  Administrator $model
     * @param  array $attributes
     * @return Administrator|\Illuminate\Database\Eloquent\Model
     */
    public function save($model, $attributes)
    {
        $this->beforeSave();

        $this->clearLanguageBuffer();

        if (array_key_exists('password', $attributes)) {
            if (is_null($attributes['password']) || $attributes['password'] == '') {
                array_forget($attributes, 'password');
            } else {
                $attributes['password'] = \Hash::make($attributes['password']);
            }
        }

        array_forget($attributes, 'password_confirmation');

        foreach ($this->languageColumns as $column) {
            if (array_key_exists($column, $attributes)) {
                $attributes[$column] = $this->exchangeLanguage($attributes, $column, $model->getAttribute($model->getKeyName()));
            }
        }

        if (count($this->languageBuffer) > 0 && !is_null(static::UPDATED_AT)) {
            $attributes[static::UPDATED_AT] = date('Y-m-d H:i:s');
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
     * Serialize input attributes to a new model
     *
     * @param  array $attributes
     * @return Administrator
     */
    protected function serialization(array $attributes)
    {
        $this->clearLanguageBuffer();

        $model = static::MODEL;
        /** @var Administrator $model */
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

        $model->setAttribute('password', \Hash::make('123456'));

        return $model;
    }
}