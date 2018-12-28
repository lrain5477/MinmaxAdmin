<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\SiteParameterItem;

/**
 * Class SiteParameterItemTransformer
 */
class SiteParameterItemTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  SiteParameterItemPresenter $presenter
     * @param  string $uri
     */
    public function __construct(SiteParameterItemPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  SiteParameterItem $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SiteParameterItem $model)
    {
        return [
            'group_id' => $this->presenter->getGridText($model->siteParameterGroup, 'title'),
            'label' => $this->presenter->getGridText($model, 'label'),
            'value' => $this->presenter->getGridText($model, 'value'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}