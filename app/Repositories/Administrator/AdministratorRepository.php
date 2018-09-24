<?php

namespace App\Repositories\Administrator;

use App\Models\Administrator;

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
}