<?php

namespace Minmax\Base\Administrator;

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

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['native'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'world_language';
    }

    protected function afterCreate()
    {
        try {
            cache()->forget('langId');
        } catch (\Exception $e) {}
    }

    protected function afterSave()
    {
        try {
            cache()->forget('langId');
        } catch (\Exception $e) {}
    }

    public function getSelectParameters($active = false)
    {
        if ($active) {
            $model = $this->all('active', true);
        } else {
            $model = $this->all();
        }
        return $model
            ->mapWithKeys(function ($item) {
                /** @var WorldLanguage $item */
                return [$item->id => ['title' => $item->native, 'options' => $item->options]];
            })
            ->toArray();
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