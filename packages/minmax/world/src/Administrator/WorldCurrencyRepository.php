<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Repository;
use Minmax\World\Models\WorldCurrency;

/**
 * Class WorldCurrencyRepository
 * @method WorldCurrency find($id)
 * @method WorldCurrency one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldCurrency create($attributes)
 * @method WorldCurrency save($model, $attributes)
 * @method WorldCurrency|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldCurrencyRepository extends Repository
{
    const MODEL = WorldCurrency::class;

    protected $hasSort = true;

    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_currency';
    }

    public function getSelectParameters()
    {
        return $this->all()
            ->mapWithKeys(function ($item) {
                /** @var WorldCurrency $item */
                return [$item->id => ['title' => $item->title, 'options' => $item->options]];
            })
            ->toArray();
    }
}