<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Admin;

/**
 * Class AdminRepository
 * @property Admin $model
 * @method Admin find($id)
 * @method Admin one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Admin|\Illuminate\Database\Eloquent\Builder query()
 * @method Admin saveLanguage($model, $columns = [])
 */
class AdminRepository extends Repository
{
    const MODEL = Admin::class;

    protected $roleSelected = [];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'admin';
    }

    protected function beforeCreate()
    {
        $this->attributes['password'] = \Hash::make('123456');

        $this->roleSelected = array_pull($this->attributes, 'role_id', []);
    }

    protected function afterCreate()
    {
        $this->model->syncRoles($this->roleSelected);
    }

    protected function beforeSave()
    {
        if ($password = array_pull($this->attributes, 'password')) {
            if ($password != '') {
                $this->attributes['password'] = \Hash::make($password);
            }
        }

        array_forget($this->attributes, 'password_confirmation');

        $this->roleSelected = array_pull($this->attributes, 'role_id', []);
    }

    protected function afterSave()
    {
        if (in_array('admin', explode('/', request()->getUri()))) {
            $this->model->syncRoles($this->roleSelected);
        }
    }

    protected function afterDelete()
    {
        \DB::table('role_user')->where(['user_id' => $this->model->getKey(), 'user_type' => get_class($this->model)])->delete();
        \DB::table('permission_user')->where(['user_id' => $this->model->getKey(), 'user_type' => get_class($this->model)])->delete();
    }

    /**
     * @return array
     */
    public function getSelectParameters()
    {
        return $this->query()
            ->where('username', '!=', 'sysadmin')
            ->orderBy('name')
            ->get()
            ->mapWithKeys(function($item) {
                /** @var \Minmax\Base\Models\Admin $item */
                return [$item->id => ['title' => "{$item->name} ({$item->username})", 'options' => null]];
            })
            ->toArray();
    }
}