<?php

namespace Minmax\Base\Administrator;

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
}