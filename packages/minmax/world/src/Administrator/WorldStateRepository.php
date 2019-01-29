<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Repository;
use Minmax\World\Models\WorldState;

/**
 * Class WorldStateRepository
 * @property WorldState $model
 * @method WorldState find($id)
 * @method WorldState one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldState create($attributes)
 * @method WorldState save($model, $attributes)
 * @method WorldState|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldStateRepository extends Repository
{
    const MODEL = WorldState::class;

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
        return 'world_state';
    }

    protected function getSortWhere()
    {
        return "country_id = '{$this->model->country_id}'";
    }

    public function getSelectParameters()
    {
        return $this->all()
            ->mapWithKeys(function ($item) {
                /** @var WorldState $item */
                return [$item->id => ['title' => $item->title, 'options' => []]];
            })
            ->toArray();
    }
}