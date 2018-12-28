<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\Role;

/**
 * Class RoleTransformer
 */
class RoleTransformer extends Transformer
{
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
            'guard' => $this->presenter->getGridSelection($model, 'guard'),
            'name' => $this->presenter->getGridText($model, 'name'),
            'display_name' => $this->presenter->getGridText($model, 'display_name'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}