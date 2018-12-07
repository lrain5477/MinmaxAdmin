<?php

namespace Minmax\Base\Admin;

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

    protected $languageColumns = ['website_name', 'company', 'contact', 'seo', 'options', 'offline_text'];

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
     * @param string $guard
     * @return WebData
     */
    public function getData($guard = null)
    {
        return $this->one('guard', $guard ?? 'admin');
    }
}