<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Role;

/**
 * Class RoleRepository
 * @property Role $model
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

    protected $permissionSelected = [];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'roles';
    }

    protected function beforeSave()
    {
        $this->permissionSelected = array_pull($this->attributes, 'permissions', []);
    }

    protected function afterSave()
    {
        $this->model->syncPermissions($this->permissionSelected);
    }

    /**
     * @param  string $guard
     * @return array
     */
    public function getSelectParameters($guard = 'admin')
    {
        return $this->query()
            ->where('guard', $guard)
            ->orderBy('name')
            ->get()
            ->mapWithKeys(function($item) {
                /** @var \Minmax\Base\Models\Role $item */
                return [$item->id => ['title' => $item->display_name, 'options' => null]];
            })
            ->toArray();
    }
}