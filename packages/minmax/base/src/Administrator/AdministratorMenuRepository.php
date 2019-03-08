<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Helpers\Tree as TreeHelper;
use Minmax\Base\Models\AdministratorMenu;

/**
 * Class AdministratorMenuRepository
 * @method AdministratorMenu find($id)
 * @method AdministratorMenu one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method AdministratorMenu create($attributes)
 * @method AdministratorMenu save($model, $attributes)
 * @method AdministratorMenu|\Illuminate\Database\Eloquent\Builder query()
 */
class AdministratorMenuRepository extends Repository
{
    const MODEL = AdministratorMenu::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'administrator_menu';
    }

    /**
     * @return array
     */
    public function getMenu()
    {
        return TreeHelper::getMenu($this->all('active', true)->sortBy('sort')->toArray());
    }
}
