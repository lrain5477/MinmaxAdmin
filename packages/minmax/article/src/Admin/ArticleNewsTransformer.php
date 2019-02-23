<?php

namespace Minmax\Article\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\Article\Models\ArticleNews;

/**
 * Class ArticleNewsTransformer
 */
class ArticleNewsTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'articleCategoryShow',
        'U' => 'articleCategoryEdit',
        'D' => 'articleCategoryDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  ArticleNewsPresenter $presenter
     * @param  string $uri
     */
    public function __construct(ArticleNewsPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  ArticleNews $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ArticleNews $model)
    {
        return [
            'id' => $this->presenter->getGridCheckBox($model),
            'pic' => $this->presenter->getGridThumbnail($model, 'pic'),
            'top' => $this->presenter->getGridTitle($model),
            'count' => $this->presenter->getGridCount($model),
            'start_at' => $this->presenter->getGridText($model, 'start_at', ['defaultValue' => $model->start_at->format('Y-m-d')]),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}