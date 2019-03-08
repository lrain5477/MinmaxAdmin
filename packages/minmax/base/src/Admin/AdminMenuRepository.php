<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Helpers\Tree as TreeHelper;
use Minmax\Base\Models\AdminMenu;

/**
 * Class AdminMenuRepository
 * @property AdminMenu $model
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
        return TreeHelper::getMenu($this->all('active', true)->sortBy('sort')->toArray());
    }
}
