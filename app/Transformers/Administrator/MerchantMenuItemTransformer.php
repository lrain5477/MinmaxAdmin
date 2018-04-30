<?php

namespace App\Transformers\Administrator;

use App\Models\MerchantMenuItem;

class MerchantMenuItemTransformer extends Transformer
{
    protected $uri = 'merchant-menu-item';
    protected $model = 'MerchantMenuItem';

    /**
     * @param MerchantMenuItem $model
     * @return array
     * @throws \Throwable
     */
    public function transform(MerchantMenuItem $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'uri' => $this->getGridText($model->uri),
            'model' => $this->getGridText($model->getAttributeValue('model')),
            'class' => $this->getGridText($model->merchantMenuClass->title),
            'parent' => $this->getGridParent($model),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }

    public function getGridParent(MerchantMenuItem $model)
    {
        $label = $model->parent == '0' ? __('administrator.grid.root') : $model->merchantMenuItem->title;

        if($model->adminMenuItem(true)->count() > 0) {
            $label .= " <a class=\"btn btn-outline-default btn-sm\" href=\"?parent={$model->guid}\" title=\"" . __('administrator.grid.next_layer') . "\">" .
                "<i class=\"icon-stack\"></i><span class=\"text-hide\">" . __('administrator.grid.next_layer') . "</span>" .
                "</a>";
        }

        return $label;
    }
}