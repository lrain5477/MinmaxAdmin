<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\WebMenu;

/**
 * Class WebMenuTransformer
 */
class WebMenuTransformer extends Transformer
{
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
        $loopLevel = 0;
        $loopModel = $model;
        do {
            $childrenFlag = ++$loopLevel < (config('app.menu_layer_limit', 2) + 1);
            if ($loopModel->parent_id) { $loopModel = $this->menuList->firstWhere('id', $loopModel->parent_id); } else { break; }
        } while ($childrenFlag);

        return [
            'title' => $this->presenter->getGridLinkTitle($model),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'editable' => $this->presenter->getGridSwitch($model, 'editable'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model, $childrenFlag
                ? [
                    ['view' => 'MinmaxBase::administrator.web-menu.action-button-children']
                ]
                : []
            ),
        ];
    }
}