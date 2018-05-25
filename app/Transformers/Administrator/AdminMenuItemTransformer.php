<?php

namespace App\Transformers\Administrator;

use App\Models\AdminMenuItem;

class AdminMenuItemTransformer extends Transformer
{
    protected $model = 'AdminMenuItem';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * @param AdminMenuItem $model
     * @return array
     * @throws \Throwable
     */
    public function transform(AdminMenuItem $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'uri' => $this->getGridText($model->uri),
            'model' => $this->getGridText($model->getAttributeValue('model')),
            'class' => $this->getGridText($model->adminMenuClass->title),
            'parent' => $this->getGridParent($model),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }

    public function getGridParent(AdminMenuItem $model)
    {
        $label = $model->parent == '0' ? __('administrator.grid.root') : $model->adminMenuItem->title;

        if($model->adminMenuItem(true)->count() > 0) {
            $label .= " <a class=\"btn btn-outline-default btn-sm\" href=\"?parent={$model->guid}\" title=\"" . __('administrator.grid.next_layer') . "\">" .
                "<i class=\"icon-stack\"></i><span class=\"text-hide\">" . __('administrator.grid.next_layer') . "</span>" .
                "</a>";
        }

        return $label;
    }
}