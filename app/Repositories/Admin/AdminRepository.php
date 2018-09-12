<?php

namespace App\Repositories\Admin;

use App\Models\Admin;

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

        $attributes['password'] = \Hash::make('123456');

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

        if (count($this->languageBuffer) > 0) {
            $attributes['updated_at'] = date('Y-m-d H:i:s');
        }

        $model->fill($attributes);

        if ($model->save()) {
            $model = $this->saveLanguage($model);
            $model->syncRoles($roleSelected);
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
}