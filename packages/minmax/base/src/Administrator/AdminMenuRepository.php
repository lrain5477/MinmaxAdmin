<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Helpers\Tree as TreeHelper;
use Minmax\Base\Models\AdminMenu;

/**
 * Class AdminMenuRepository
 * @method AdminMenu find($id)
 * @method AdminMenu one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method AdminMenu create($attributes)
 * @method AdminMenu save($model, $attributes)
 * @method AdminMenu|\Illuminate\Database\Eloquent\Builder query()
 */
class AdminMenuRepository extends Repository
{
    const MODEL = AdminMenu::class;

    protected $hasSort = true;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'admin_menu';
    }

    public function getSelectParameters()
    {
        $menuSet = TreeHelper::getMenu($this->all()->sortBy('sort')->toArray());

        $result = [
            '' => ['title' => '(' . __('MinmaxBase::administrator.grid.root') . ')', 'options' => []]
        ];
        foreach ($menuSet as $classMenu) {
            $result[$classMenu['id']] = ['title' => $classMenu['title'], 'options' => []];
            foreach ($classMenu['children'] as $rootMenu) {
                $result[$rootMenu['id']] = ['title' => '├─ ' . $rootMenu['title'], 'options' => []];
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
                $breadcrumbs->push($current->title, langRoute('administrator.' . $uri . '.index', ['parent' => $currentId]));
            }
        } else {
            $breadcrumbs->push(__('MinmaxBase::administrator.grid.root'), langRoute('administrator.' . $uri . '.index'));
        }
    }
}