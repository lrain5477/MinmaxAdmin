<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Role;

class RoleTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'roleShow',
        'U' => 'roleEdit',
        'D' => 'roleDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
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