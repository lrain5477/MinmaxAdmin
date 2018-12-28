<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Admin;

/**
 * Class AdminRepository
 * @method Admin find($id)
 * @method Admin one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Admin|\Illuminate\Database\Eloquent\Builder query()
 * @method Admin saveLanguage($model, $columns = [])
 */
class AdminRepository extends Repository
{
    const MODEL = Admin::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'admin';
    }

    /**
     * Create a new model
     *
     * @param  array $attributes
     * @return Admin|\Illuminate\Database\Eloquent\Model|null
     */
    public function create($attributes)
    {
        $this->beforeCreate();

        $roleSelected = array_pull($attributes, 'role_id', []);

        $model = $this->serialization($attributes);

        try {
            if ($model->save()) {
                $model = $this->saveLanguage($model);
                $model->syncRoles($roleSelected);

                $this->afterCreate();

                return $model;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param  Admin $model
     * @param  array $attributes
     * @return Admin|\Illuminate\Database\Eloquent\Model
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

        $roleSelected = array_pull($attributes, 'role_id', []);

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
            if (in_array('admin', explode('/', request()->getUri()))) {
                $model->syncRoles($roleSelected);
            }
            return $model;
        }

        $this->afterSave();

        return null;
    }

    /**
     * @param  Admin $model
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
                \DB::table('role_user')->where(['user_id' => $model->getKey(), 'user_type' => get_class($model)])->delete();
                \DB::table('permission_user')->where(['user_id' => $model->getKey(), 'user_type' => get_class($model)])->delete();
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
     * Serialize input attributes to a new model
     *
     * @param  array $attributes
     * @return Admin
     */
    protected function serialization(array $attributes)
    {
        $this->clearLanguageBuffer();

        $model = static::MODEL;
        /** @var Admin $model */
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