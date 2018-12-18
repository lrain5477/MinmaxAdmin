<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Role;

/**
 * Class RoleRepository
 * @method Role find($id)
 * @method Role one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Role create($attributes)
 * @method Role saveLanguage($model)
 * @method Role|\Illuminate\Database\Eloquent\Builder query()
 */
class RoleRepository extends Repository
{
    const MODEL = Role::class;

    protected $languageColumns = ['display_name', 'description'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'roles';
    }

    /**
     * @param  Role $model
     * @param  array $attributes
     * @return Role
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

        if (count($this->languageBuffer) > 0 && !is_null(static::UPDATED_AT)) {
            $attributes[static::UPDATED_AT] = date('Y-m-d H:i:s');
        }

        $permissions = array_pull($attributes, 'permissions', []);

        $model->fill($attributes);

        if ($model->save()) {
            $model = $this->saveLanguage($model);
            $model->syncPermissions($permissions);
            return $model;
        }

        $this->afterSave();

        return null;
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

        $model->setAttribute('guard', 'admin');

        return $model;
    }
}