<?php

namespace Minmax\Base\Administrator;

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

    public function getSelectParameters($showDeepest = false)
    {
        $menuSet = TreeHelper::getMenu($this->all()->sortBy('sort')->toArray());
        $list = TreeHelper::getList($menuSet, 1, config('app.menu_layer_limit', 2) - ($showDeepest ? 0 : 1));

        $result = [
            '' => ['title' => '(' . __('MinmaxBase::administrator.grid.root') . ')', 'options' => []]
        ];

        foreach ($list as $menuItem) {
            $prefix = '├';
            for ($current = 2; $current < $menuItem['layer']; $current++) $prefix .= '─';
            $prefix = $menuItem['layer'] == 1 ? '' : $prefix;
            $result[$menuItem['id']] = ['title' => $prefix . ' ' . $menuItem['title'], 'options' => []];
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