<?php

namespace Minmax\Article\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\Article\Models\ArticleCategory;

/**
 * Class ArticleCategoryTransformer
 */
class ArticleCategoryTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'articleCategoryShow',
        'U' => 'articleCategoryEdit',
        'D' => 'articleCategoryDestroy',
    ];

    protected $menuList;

    /**
     * Transformer constructor. Put action permissions.
     * @param  ArticleCategoryPresenter $presenter
     * @param  string $uri
     */
    public function __construct(ArticleCategoryPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        $this->menuList = (new ArticleCategoryRepository)->all();

        parent::__construct($uri);
    }

    /**
     * @param  ArticleCategory $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ArticleCategory $model)
    {
        $loopLevel = 0;
        $loopModel = $model;
        do {
            $childrenFlag = ++$loopLevel < config('app.article_layer_limit', 3);
            if ($loopModel->parent_id) { $loopModel = $this->menuList->firstWhere('id', $loopModel->parent_id); } else { break; }
        } while ($childrenFlag);

        if ($model->editable) {
            $this->presenter->setPermissions($this->permissions);
        } else {
            $this->presenter->setPermissions($this->permissions, ['U', 'D']);
        }

        return [
            'title' => $this->presenter->getGridText($model, 'title'),
            'obj_amount' => $this->presenter->getGridObjAmount($model),
            'sub_amount' => $this->presenter->getGridSubAmount($model, $childrenFlag),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model, $childrenFlag
                ? [
                    ['permission' => 'R', 'view' => 'MinmaxArticle::admin.article-category.action-button-children']
                ]
                : []
            ),
        ];
    }
}