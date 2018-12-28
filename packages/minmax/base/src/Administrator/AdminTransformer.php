<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\Admin;

/**
 * Class AdminTransformer
 */
class AdminTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  AdminPresenter $presenter
     * @param  string $uri
     */
    public function __construct(AdminPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  Admin $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Admin $model)
    {
        return [
            'username' => $this->presenter->getGridText($model, 'username'),
            'name' => $this->presenter->getGridText($model, 'name'),
            'email' => $this->presenter->getGridText($model, 'email'),
            'role_id' => $this->presenter->getPureString($model->roles->pluck('display_name')->implode(', ')),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}