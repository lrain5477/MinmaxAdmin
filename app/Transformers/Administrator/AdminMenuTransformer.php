<?php

namespace App\Transformers\Administrator;

use App\Models\AdminMenu;

class AdminMenuTransformer extends Transformer
{
    protected $model = 'AdminMenu';
    protected $parameterSet = [
        'active',
    ];

    /**
     * @param AdminMenu $model
     * @return array
     * @throws \Throwable
     */
    public function transform(AdminMenu $model)
    {
        return [
            'uri' => $this->getGridText($model->uri),
            'title' => $this->getGridText($model->title),
            'parent_id' => $this->getGridParent($model),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }

    public function getGridParent(AdminMenu $model)
    {
        $label = __('administrator.grid.root');

        if ($parent = AdminMenu::query()->where('guid', $model->parent_id)->first()) {
            $label = $parent->title;
        }

        if (AdminMenu::query()->where('parent_id', $model->guid)->count() > 0) {
            $label .= " <a class=\"btn btn-outline-default btn-sm\" href=\"?parent={$model->guid}\" title=\"" . __('administrator.grid.next_layer') . "\">" .
                "<i class=\"icon-stack\"></i><span class=\"text-hide\">" . __('administrator.grid.next_layer') . "</span>" .
                "</a>";
        }

        return $label;
    }
}