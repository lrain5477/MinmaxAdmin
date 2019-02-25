<?php

namespace Minmax\Ad\Web;

use Minmax\Base\Web\Repository;
use Minmax\Ad\Models\Advertising;

/**
 * Class AdvertisingRepository
 * @property Advertising $model
 * @method Advertising find($id)
 * @method Advertising one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Advertising create($attributes)
 * @method Advertising save($model, $attributes)
 * @method Advertising|\Illuminate\Database\Eloquent\Builder query()
 */
class AdvertisingRepository extends Repository
{
    const MODEL = Advertising::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'advertising';
    }

    /**
     * @param  string $category
     * @return \Illuminate\Database\Eloquent\Collection|Advertising[]
     */
    public function getAdvertising($category)
    {
        return $this->query()
            ->whereHas('advertisingCategory', function ($query) use ($category) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where(['code' => $category, 'active' => true]);
            })
            ->where(function ($query) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->whereNull('start_at')->orWhere('start_at', '<=', date('Y-m-d H:i:s'));
            })
            ->where(function ($query) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->whereNull('end_at')->orWhere('end_at', '>=', date('Y-m-d H:i:s'));
            })
            ->where('active', true)
            ->orderBy('sort')
            ->get();
    }
}