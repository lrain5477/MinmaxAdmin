<?php

namespace Minmax\Base\Web;

use Minmax\Base\Models\SiteParameterItem;

/**
 * Class SiteParameterItemRepository
 * @property SiteParameterItem $model
 * @method SiteParameterItem find($id)
 * @method SiteParameterItem one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SiteParameterItem create($attributes)
 * @method SiteParameterItem save($model, $attributes)
 * @method SiteParameterItem|\Illuminate\Database\Eloquent\Builder query()
 */
class SiteParameterItemRepository extends Repository
{
    const MODEL = SiteParameterItem::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'site_parameter_item';
    }
}