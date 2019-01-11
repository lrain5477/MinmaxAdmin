<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Repository;
use Minmax\World\Models\WorldCountry;

/**
 * Class WorldCountryRepository
 * @property WorldCountry $model
 * @method WorldCountry find($id)
 * @method WorldCountry one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldCountry create($attributes)
 * @method WorldCountry save($model, $attributes)
 * @method WorldCountry|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldCountryRepository extends Repository
{
    const MODEL = WorldCountry::class;

    protected $hasSort = true;

    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_country';
    }

    public function getSelectParameters()
    {
        return $this->all()
            ->mapWithKeys(function ($item) {
                /** @var WorldCountry $item */
                return [$item->id => ['title' => $item->title, 'options' => []]];
            })
            ->toArray();
    }
}