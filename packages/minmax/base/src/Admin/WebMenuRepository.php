<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Helpers\Tree as TreeHelper;
use Minmax\Base\Models\WebMenu;

/**
 * Class WebMenuRepository
 * @property WebMenu $model
 * @method WebMenu find($id)
 * @method WebMenu one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method WebMenu create($attributes)
 * @method WebMenu save($model, $attributes)
 * @method WebMenu|\Illuminate\Database\Eloquent\Builder query()
 */
class WebMenuRepository extends Repository
{
    const MODEL = WebMenu::class;

    protected $sort = 'sort';

    protected $sorting = true;

    protected $languageColumns = ['title'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'web_menu';
    }

    protected function getSortWhere()
    {
        if (is_null($this->model->parent_id)) {
            return "parent_id is null";
        } else {
            return "parent_id = '{$this->model->parent_id}'";
        }
    }

    public function getSelectParameters()
    {
        $menuSet = TreeHelper::getMenu($this->all()->sortBy('sort')->toArray());

        $result = [];

        foreach ($menuSet as $classMenu) {
            $result[$classMenu['id']] = ['title' => $classMenu['title'], 'options' => []];

            for ($current = 1; $current < config('app.menu_layer_limit', 2); $current++) {
                $prefix = '├';
                for ($s = 0; $s < $current; $s++) $prefix .= '─';

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