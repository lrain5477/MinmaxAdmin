<?php

namespace Minmax\Ad\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Ad\Models\AdvertisingCategory;

/**
 * Class AdvertisingCategoryRepository
 * @property AdvertisingCategory $model
 * @method AdvertisingCategory find($id)
 * @method AdvertisingCategory one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method AdvertisingCategory create($attributes)
 * @method AdvertisingCategory save($model, $attributes)
 * @method AdvertisingCategory|\Illuminate\Database\Eloquent\Builder query()
 */
class AdvertisingCategoryRepository extends Repository
{
    const MODEL = AdvertisingCategory::class;

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['title', 'remark'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'advertising_category';
    }

    public function getSelectParameters()
    {
        return $this->all()
            ->sortBy('sort')
            ->mapWithKeys(function ($item) {
                /** @var AdvertisingCategory $item */
                $sizeHint = '';
                $sizeWidth = array_get($item->options, 'width');
                $sizeHeight = array_get($item->options, 'height');

                if (!is_null($sizeWidth) && !is_null($sizeHeight)) {
                    $sizeHint = " ({$sizeWidth}px * {$sizeHeight}px)";
                } elseif (!is_null($sizeWidth)) {
                    $sizeHint = " (W: {$sizeWidth}px)";
                } elseif (!is_null($sizeHeight)) {
                    $sizeHint = " (H: {$sizeHeight}px)";
                }

                return [$item->id => ['title' => $item->title . $sizeHint, 'options' => []]];
            })
            ->toArray();
    }
}