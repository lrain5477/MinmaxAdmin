<?php

namespace App\Repositories\Admin;

use App\Models\AdminMenu;

/**
 * Class AdminMenuRepository
 * @method AdminMenu create($attributes)
 * @method AdminMenu save($model, $attributes)
 */
class AdminMenuRepository extends Repository
{
    const MODEL = AdminMenu::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'admin_menu';
    }
}