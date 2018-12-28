<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\Permission;

/**
 * Class PermissionTransformer
 */
class PermissionTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  PermissionPresenter $presenter
     * @param  string $uri
     */
    public function __construct(PermissionPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  Permission $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Permission $model)
    {
        return [
            'guard' => $this->presenter->getGridSelection($model, 'guard'),
            'group' => $this->presenter->getGridText($model, 'group'),
            'name' => $this->presenter->getGridText($model, 'name'),
            'display_name' => $this->presenter->getGridText($model, 'display_name'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}