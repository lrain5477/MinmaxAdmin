<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Repository;
use Minmax\Base\Helpers\Tree as TreeHelper;
use Minmax\Product\Models\ProductCategory;

/**
 * Class ProductCategoryRepository
 * @property ProductCategory $model
 * @method ProductCategory find($id)
 * @method ProductCategory one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ProductCategory create($attributes)
 * @method ProductCategory save($model, $attributes)
 * @method ProductCategory|\Illuminate\Database\Eloquent\Builder query()
 */
class ProductCategoryRepository extends Repository
{
    const MODEL = ProductCategory::class;

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['title', 'details'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_category';
    }

    protected function getSortWhere()
    {
        if (is_null($this->model->parent_id)) {
            return "parent_id is null";
        } else {
            return "parent_id = '{$this->model->parent_id}'";
        }
    }

    public function getSelectParameters($hasRoot = true, $showDeepest = false)
    {
        $categories = TreeHelper::getMenu($this->all()->sortBy('sort')->toArray());
        $list = TreeHelper::getList($categories, 1, config('app.ecommerce_layer_limit', 3) - ($showDeepest ? 0 : 1));

        $result = $hasRoot
            ? [
                '' => ['title' => '(' . __('MinmaxBase::administrator.grid.root') . ')', 'options' => ['text' => 'root']]
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
                $breadcrumbs->push($current->title, langRoute('administrator.' . $uri . '.index', ['parent' => $currentId]));
            }
        } else {
            $breadcrumbs->push(__('MinmaxBase::administrator.grid.root'), langRoute('administrator.' . $uri . '.index'));
        }
    }
}