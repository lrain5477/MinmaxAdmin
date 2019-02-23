<?php

namespace Minmax\Article\Admin;

use Illuminate\Support\Facades\DB;
use Minmax\Article\Models\ArticleNews;
use Minmax\Base\Admin\ColumnExtensionRepository;
use Minmax\Base\Admin\Presenter;

/**
 * Class ArticleNewsPresenter
 */
class ArticleNewsPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxArticle::';

    protected $languageColumns = ['title', 'description', 'editor', 'seo'];

    protected $clickCountSet = [];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'categories' => (new ArticleCategoryRepository)->getArticleCategorySelection('article-news'),
            'top' => systemParam('top'),
            'active' => systemParam('active'),
        ];

        $this->clickCountSet = DB::table('article_track')
            ->where('model', ArticleNews::class)
            ->select(['object_id', DB::raw('count(*) as `num`')])
            ->groupBy('object_id')
            ->pluck('num', 'object_id')
            ->toArray();
    }

    /**
     * @param  \Minmax\Article\Models\ArticleNews $model
     * @return integer
     */
    public function getGridTitle($model)
    {
        $titleValue = $model->title;
        $shortValue = is_null($model->description) ? trim(strip_tags($model->editor)) : trim($model->description);
        $shortValue = mb_strlen($shortValue) <= 60 ? $shortValue : (mb_substr($shortValue, 20) . '...');

        $urlValue = 'javascript:void(0);';
        if (in_array('R', $this->permissionSet)) {
            $urlValue = langRoute('admin.article-news.show', ['id' => $model->id]);
        }
        if (in_array('U', $this->permissionSet)) {
            $urlValue = langRoute('admin.article-news.edit', ['id' => $model->id]);
        }

        $isTop = $model->top
            ? '<span class="badge badge-pill badge-warning ml-2">' . __('MinmaxArticle::admin.grid.ArticleNews.tags.top') . '</span>'
            : '';

        $categories = $model->articleCategories->pluck('title')->implode(', ');
        $categories = mb_strlen($categories) <= 20 ? $categories : (mb_substr($categories, 20) . '...');

        $thisHtml = <<<HTML
<h3 class="h6 d-inline d-sm-block">
    <a class="text-pre-line" href="{$urlValue}">{$titleValue}</a>{$isTop}
</h3>
<p class="m-0 p-0 text-pre-line">{$shortValue}</p>
<small class="text-success float-right">{$categories}</small>
HTML;

        return $thisHtml;
    }

    /**
     * @param  \Minmax\Article\Models\ArticleNews $model
     * @return integer
     */
    public function getGridCount($model)
    {
        return array_get($this->clickCountSet, $model->id, 0);
    }
}