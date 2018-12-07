<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\WorldLanguage;

/**
 * Class WorldLanguageRepository
 * @method WorldLanguage find($id)
 * @method WorldLanguage one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WorldLanguage create($attributes)
 * @method WorldLanguage save($model, $attributes)
 * @method WorldLanguage|\Illuminate\Database\Eloquent\Builder query()
 */
class WorldLanguageRepository extends Repository
{
    const MODEL = WorldLanguage::class;
    protected $languageColumns = ['name'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_language';
    }

    protected function beforeCreate()
    {
        \Cache::forget('langId');
    }

    public function getLanguageList()
    {
        return $this->query()
            ->where('active_admin', true)
            ->where('active', true)
            ->orderBy('sort')
            ->get();
    }

    public function getLanguageActive()
    {
        $currentFormLocal = session('admin-formLocal', app()->getLocale());

        return $this->query()
            ->where('active', true)
            ->orderBy('sort')
            ->get()
            ->map(function ($item) use ($currentFormLocal) {
                $item->current = $item->code == $currentFormLocal;
                return $item;
            });
    }
}