<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Admin;

class AdminTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'adminShow',
        'U' => 'adminEdit',
        'D' => 'adminDestroy',
    ];

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
        $isSelf = $model->id === request()->user('admin')->id;

        // Can't destroy self. Without Destroy permission.
        if($isSelf) {
            $this->presenter->setPermissions($this->permissions, 'D');
        }

        $transformerData = [
            'username' => $this->presenter->getGridText($model, 'username'),
            'name' => $this->presenter->getGridText($model, 'name'),
            'email' => $this->presenter->getGridText($model, 'email'),
            'role_id' => $this->presenter->getPureString($model->roles()->get()->pluck('display_name')->implode(', ')),
            'active' => $isSelf
                ? $this->presenter->getGridTextBadge($model, 'active')
                : $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];

        // After put Destroy permission back, if it was removed at first.
        if($isSelf) {
            $this->presenter->setPermissions($this->permissions);
        }

        return $transformerData;
    }
}