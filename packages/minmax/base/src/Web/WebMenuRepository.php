<?php

namespace Minmax\Base\Web;

use Minmax\Base\Helpers\Tree as TreeHelper;
use Minmax\Base\Models\WebMenu;

/**
 * Class WebMenuRepository
 * @method WebMenu find($id)
 * @method WebMenu one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WebMenu create($attributes)
 * @method WebMenu save($model, $attributes)
 * @method WebMenu|\Illuminate\Database\Eloquent\Builder query()
 */
class WebMenuRepository extends Repository
{
    const MODEL = WebMenu::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'web_menu';
    }

    /**
     * @return array
     */
    public function getMenu()
    {
        return TreeHelper::getMenu($this->all()->sortBy('sort')->toArray());
    }
}