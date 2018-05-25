<?php

namespace App\Transformers\Admin;

use App\Models\ParameterItem;

class ParameterItemTransformer extends Transformer
{
    protected $model = 'ParameterItem';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(\Auth::guard('admin')->user()->can('parameterItemShow')) $this->permissions[] = 'R';
        if(\Auth::guard('admin')->user()->can('parameterItemEdit')) $this->permissions[] = 'U';
        if(\Auth::guard('admin')->user()->can('parameterItemDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param ParameterItem $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ParameterItem $model)
    {
        return [
            'group' => $this->getGridText($model->parameterGroup->title),
            'title' => $this->getGridText($model->title),
            'value' => $this->getGridText($model->value),
            'sort' => $this->getGridSort($model->guid, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}