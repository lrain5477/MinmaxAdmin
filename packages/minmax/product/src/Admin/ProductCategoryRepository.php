<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Repository;
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

    protected $hasSort = true;

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

    public function getSelectParameters()
    {
        $menuSet = TreeHelper::getMenu($this->all()->sortBy('sort')->toArray());

        $result = [
            '' => ['title' => '(' . __('MinmaxBase::admin.grid.root') . ')', 'options' => []]
        ];

        foreach ($menuSet as $classMenu) {
            $result[$classMenu['id']] = ['title' => $classMenu['title'], 'options' => []];

            for ($current = 1; $current < config('app.ecommerce_layer_limit', 3); $current++) {
                $prefix = '├';
                for ($s = 1; $s < $current; $s++) $prefix .= '─';

                foreach ($classMenu['children'] as $rootMenu) {
                    $result[$rootMenu['id']] = ['title' => $prefix . ' ' . $rootMenu['title'], 'options' => []];
                }
            }
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
                $breadcrumbs->push($current->title, langRoute('admin.' . $uri . '.index', ['parent' => $currentId]));
            }
        } else {
            $breadcrumbs->push(__('MinmaxBase::admin.grid.root'), langRoute('admin.' . $uri . '.index'));
        }
    }
}