<?php

namespace Minmax\Base\Web;

use Minmax\Base\Models\WebData;

/**
 * Class WebDataRepository
 * @method WebData find($id)
 * @method WebData one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WebData create($attributes)
 * @method WebData save($model, $attributes)
 * @method WebData|\Illuminate\Database\Eloquent\Builder query()
 */
class WebDataRepository extends Repository
{
    const MODEL = WebData::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'web_data';
    }

    /**
     * @return WebData
     */
    public function getData()
    {
        return $this->one('guard', 'web');
    }
}