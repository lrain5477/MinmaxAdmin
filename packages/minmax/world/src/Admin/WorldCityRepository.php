<?php

namespace Minmax\World\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\World\Models\WorldCity;

/**
 * Class WorldCityRepository
 * @property WorldCity $model
 * @method WorldCity find($id)
 * @method WorldCity one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldCity create($attributes)
 * @method WorldCity save($model, $attributes)
 * @method WorldCity|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldCityRepository extends Repository
{
    const MODEL = WorldCity::class;

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_city';
    }

    protected function getSortWhere()
    {
        return "county_id = '{$this->model->county_id}'";
    }

    public function getSelectParameters($groupByCounty = false)
    {
        $citySet = $this->query()
            ->with(['worldCounty'])
            ->orderBy('sort')
            ->orderBy('code')
            ->get()
            ->mapWithKeys(function ($item) {
                /** @var WorldCity $item */
                return [$item->id => ['title' => $item->title, 'options' => [], 'parent' => $item->worldCounty->title]];
            });

        return $groupByCounty
            ? $citySet->groupBy('parent', true)->toArray()
            : $citySet->toArray();
    }
}