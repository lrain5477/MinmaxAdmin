<?php

namespace Minmax\Base\Web;

use Minmax\Base\Models\SiteParameterGroup;

/**
 * Class SiteParameterGroupRepository
 * @property SiteParameterGroup $model
 * @method SiteParameterGroup find($id)
 * @method SiteParameterGroup one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method SiteParameterGroup create($attributes)
 * @method SiteParameterGroup save($model, $attributes)
 * @method SiteParameterGroup|\Illuminate\Database\Eloquent\Builder query()
 */
class SiteParameterGroupRepository extends Repository
{
    const MODEL = SiteParameterGroup::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'site_parameter_group';
    }
}