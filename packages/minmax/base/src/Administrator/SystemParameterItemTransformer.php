<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\SystemParameterItem;

/**
 * Class SystemParameterItemTransformer
 */
class SystemParameterItemTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  SystemParameterItemPresenter $presenter
     * @param  string $uri
     */
    public function __construct(SystemParameterItemPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  SystemParameterItem $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SystemParameterItem $model)
    {
        return [
            'group_id' => $this->presenter->getGridText($model->systemParameterGroup, 'title'),
            'label' => $this->presenter->getGridText($model, 'label'),
            'value' => $this->presenter->getGridText($model, 'value'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}