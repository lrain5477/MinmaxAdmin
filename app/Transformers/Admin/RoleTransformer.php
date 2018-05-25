<?php

namespace App\Transformers\Admin;

use App\Models\Role;

class RoleTransformer extends Transformer
{
    protected $model = 'Role';
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

        if(\Auth::guard('admin')->user()->can('roleShow')) $this->permissions[] = 'R';
        if(\Auth::guard('admin')->user()->can('roleEdit')) $this->permissions[] = 'U';
        if(\Auth::guard('admin')->user()->can('roleDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param Role $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Role $model)
    {
        return [
            'guard' => $this->getGridText($model->guard),
            'name' => $this->getGridText($model->name),
            'display_name' => $this->getGridText($model->display_name),
            'active' => $this->getGridSwitch($model->id, 'active', $model->active),
            'action' => $this->getGridActions($model->id),
        ];
    }
}