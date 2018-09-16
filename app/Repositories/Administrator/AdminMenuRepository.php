<?php

namespace App\Repositories\Administrator;

use App\Helpers\TreeHelper;
use App\Models\AdminMenu;

/**
 * Class AdminMenuRepository
 * @method AdminMenu find($id)
 * @method AdminMenu one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method AdminMenu create($attributes)
 * @method AdminMenu save($model, $attributes)
 * @method AdminMenu|\Illuminate\Database\Eloquent\Builder query()
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

    /**
     * @return array
     */
    public function getMenu()
    {
        return TreeHelper::getMenu($this->all()->sortBy('sort')->toArray());
    }
}