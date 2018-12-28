<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\AdminMenu;

/**
 * Class AdminMenuTransformer
 */
class AdminMenuTransformer extends Transformer
{
    protected $menuList;

    /**
     * Transformer constructor. Put action permissions.
     * @param  AdminMenuPresenter $presenter
     * @param  string $uri
     */
    public function __construct(AdminMenuPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        $this->menuList = (new AdminMenuRepository)->all();

        parent::__construct($uri);
    }

    /**
     * @param  AdminMenu $model
     * @return array
     * @throws \Throwable
     */
    public function transform(AdminMenu $model)
    {
        $loopLevel = 0;
        $loopModel = $model;
        do {
            $childrenFlag = ++$loopLevel < 3;
            if ($loopModel->parent_id) { $loopModel = $this->menuList->firstWhere('id', $loopModel->parent_id); } else { break; }
        } while ($childrenFlag);

        return [
            'title' => $this->presenter->getGridText($model, 'title'),
            'uri' => $this->presenter->getGridText($model, 'uri'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model, $childrenFlag
                ? [
                    ['view' => 'MinmaxBase::administrator.admin-menu.action-button-children']
                ]
                : []
            ),
        ];
    }
}