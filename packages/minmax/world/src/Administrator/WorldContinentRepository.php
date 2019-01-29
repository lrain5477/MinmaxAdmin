<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Repository;
use Minmax\World\Models\WorldContinent;

/**
 * Class WorldContinentRepository
 * @property WorldContinent $model
 * @method WorldContinent find($id)
 * @method WorldContinent one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldContinent create($attributes)
 * @method WorldContinent save($model, $attributes)
 * @method WorldContinent|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldContinentRepository extends Repository
{
    const MODEL = WorldContinent::class;

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
        return 'world_continent';
    }

    public function getSelectParameters()
    {
        return $this->all()
            ->mapWithKeys(function ($item) {
                /** @var WorldContinent $item */
                return [$item->id => ['title' => $item->title, 'options' => []]];
            })
            ->toArray();
    }
}