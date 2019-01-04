<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\Permission;

/**
 * Class PermissionRepository
 * @method Permission find($id)
 * @method Permission one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Permission create($attributes)
 * @method Permission save($model, $attributes)
 * @method Permission|\Illuminate\Database\Eloquent\Builder query()
 */
class PermissionRepository extends Repository
{
    const MODEL = Permission::class;

    protected $hasSort = true;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'permissions';
    }

    public function getSelectParameters($guard = 'admin')
    {
        return $this->all('guard', $guard)
            ->sortBy('sort')
            ->mapWithKeys(function ($item) {
                /** @var Permission $item */
                return [$item->name => ['title' => $item->display_name . ' (' . $item->name . ')', 'options' => []]];
            })
            ->toArray();
    }
}