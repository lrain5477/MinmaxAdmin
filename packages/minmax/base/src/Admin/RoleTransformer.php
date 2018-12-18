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
     * @param  RolePresenter $presenter
     * @param  string $uri
     */
    public function __construct(RolePresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  Role $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Role $model)
    {
        return [
            'name' => $this->presenter->getGridText($model, 'name'),
            'display_name' => $this->presenter->getGridText($model, 'display_name'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}
