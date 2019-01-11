<?php

namespace Minmax\Base\Web;

use Minmax\Base\Models\WorldLanguage;

/**
 * Class WorldLanguageRepository
 * @property WorldLanguage $model
 * @method WorldLanguage find($id)
 * @method WorldLanguage one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldLanguage create($attributes)
 * @method WorldLanguage save($model, $attributes)
 * @method WorldLanguage|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldLanguageRepository extends Repository
{
    const MODEL = WorldLanguage::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_language';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|WorldLanguage[]
     */
    public function getLanguageList()
    {
        return $this->query()
            ->where('active', true)
            ->orderBy('sort')
            ->get();
    }
}