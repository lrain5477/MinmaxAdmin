<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Role;

class RoleTransformer extends Transformer
{
    protected $model = 'Role';
    protected $parameterSet = [
        'active',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(request()->user('admin')->can('roleShow')) $this->permissions[] = 'R';
        if(request()->user('admin')->can('roleEdit')) $this->permissions[] = 'U';
        if(request()->user('admin')->can('roleDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param Role $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Role $model)
    {
        return [
            'name' => $this->getGridText($model->name),
            'display_name' => $this->getGridText($model->display_name),
            'active' => $this->getGridSwitch($model->id, 'active', $model->active),
            'action' => $this->getGridActions($model->id),
        ];
    }
}