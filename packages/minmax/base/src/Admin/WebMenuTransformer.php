<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\WebMenu;

/**
 * Class WebMenuTransformer
 */
class WebMenuTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'webMenuShow',
        'U' => 'webMenuEdit',
        'D' => 'webMenuDestroy',
    ];

    protected $menuList;

    /**
     * Transformer constructor. Put action permissions.
     * @param  WebMenuPresenter $presenter
     * @param  string $uri
     */
    public function __construct(WebMenuPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        $this->menuList = (new WebMenuRepository)->all();

        parent::__construct($uri);
    }

    /**
     * @param  WebMenu $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WebMenu $model)
    {
        // Can't destroy data editable. Without Destroy permission.
        if (! $model->editable) {
            $this->presenter->setPermissions($this->permissions, 'D');
        }

        if (is_null($model->parent_id)) {
            $this->presenter->setPermissions($this->permissions, ['U', 'D']);
        }

        $loopLevel = 0;
        $loopModel = $model;
        do {
            $childrenFlag = ++$loopLevel < (config('app.menu_layer_limit', 2) + 1);
            if ($loopModel->parent_id) { $loopModel = $this->menuList->firstWhere('id', $loopModel->parent_id); } else { break; }
        } while ($childrenFlag);

        $transformerData = [
            'title' => $this->presenter->getGridLinkTitle($model),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model, $childrenFlag
                ? [
                    ['permission' => 'R', 'view' => 'MinmaxBase::admin.web-menu.action-button-children']
                ]
                : []
            ),
        ];

        // After put permissions back, if it was removed at first.
        $this->presenter->setPermissions($this->permissions);

        return $transformerData;
    }
}