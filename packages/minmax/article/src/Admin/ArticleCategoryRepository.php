<?php

namespace Minmax\Article\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Base\Helpers\Tree as TreeHelper;
use Minmax\Article\Models\ArticleCategory;

/**
 * Class ArticleCategoryRepository
 * @property ArticleCategory $model
 * @method ArticleCategory find($id)
 * @method ArticleCategory one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ArticleCategory create($attributes)
 * @method ArticleCategory save($model, $attributes)
 * @method ArticleCategory|\Illuminate\Database\Eloquent\Builder query()
 */
class ArticleCategoryRepository extends Repository
{
    const MODEL = ArticleCategory::class;

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['title', 'details', 'seo'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'article_category';
    }

    protected function getSortWhere()
    {
        if (is_null($this->model->parent_id)) {
            return "parent_id is null";
        } else {
            return "parent_id = '{$this->model->parent_id}'";
        }
    }

    public function getSelectParameters($hasRoot = false, $showDeepest = false)
    {
        $categories = TreeHelper::getMenu($this->all()->sortBy('sort')->toArray());
        $list = TreeHelper::getList($categories, 1, config('app.article_layer_limit', 3) - ($showDeepest ? 0 : 1));

        $result = $hasRoot
            ? [
                '' => ['title' => '(' . __('MinmaxBase::admin.grid.root') . ')', 'options' => ['text' => 'root']]
            ]
            : [];

        foreach ($list as $item) {
            $prefix = '├';
            for ($current = $hasRoot ? 1 : 2; $current < $item['layer']; $current++) $prefix .= '─';
            $prefix = !$hasRoot && $item['layer'] == 1 ? '' : $prefix;
            $result[$item['id']] = ['title' => $prefix . ' ' . $item['title'], 'options' => ['text' => $item['title']]];
        }

        return $result;
    }

    public function getArticleCategorySelection($root)
    {
        if ($rootModel = $this->one('uri', $root)) {
            $categories = TreeHelper::getMenu($this->all()->sortBy('sort')->toArray(), $rootModel->id);
            $list = TreeHelper::getList($categories, 2, config('app.article_layer_limit', 3));

            $result = [];

            foreach ($list as $item) {
                $prefix = '├';
                for ($current = 1; $current < $item['layer'] - 1; $current++) $prefix .= '─';
                $prefix = $item['layer'] == 2 ? '' : $prefix;
                $result[$item['id']] = ['title' => $prefix . ' ' . $item['title'], 'options' => ['text' => $item['title']]];
            }

            return $result;
        }

        return [];
    }

    /**
     * @param  \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
     * @param  string $uri
     * @param  string|integer $currentId
     */
    public function setBreadcrumbs($breadcrumbs, $uri, $currentId = null)
    {
        if ($currentId) {
            if ($current = $this->one('id', $currentId)) {
                $this->setBreadcrumbs($breadcrumbs, $uri, $current->parent_id);
                $breadcrumbs->push($current->title, langRoute('admin.' . $uri . '.index', ['parent' => $currentId]));
            }
        } else {
            $breadcrumbs->push(__('MinmaxBase::admin.grid.root'), langRoute('admin.' . $uri . '.index'));
        }
    }
}