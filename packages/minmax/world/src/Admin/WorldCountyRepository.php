<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\World\Models\WorldCounty;

/**
 * Class WorldCountyRepository
 * @property WorldCounty $model
 * @method WorldCounty find($id)
 * @method WorldCounty one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldCounty create($attributes)
 * @method WorldCounty save($model, $attributes)
 * @method WorldCounty|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldCountyRepository extends Repository
{
    const MODEL = WorldCounty::class;

    protected $hasSort = true;

    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_county';
    }

    public function getSelectParameters()
    {
        return $this->all()
            ->mapWithKeys(function ($item) {
                /** @var WorldCounty $item */
                return [$item->id => ['title' => $item->title, 'options' => []]];
            })
            ->toArray();
    }
}