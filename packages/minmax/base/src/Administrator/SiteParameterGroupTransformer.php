<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\SiteParameterGroup;

/**
 * Class SiteParameterGroupTransformer
 */
class SiteParameterGroupTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  SiteParameterGroupPresenter $presenter
     * @param  string $uri
     */
    public function __construct(SiteParameterGroupPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  SiteParameterGroup $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SiteParameterGroup $model)
    {
        return [
            'title' => $this->presenter->getGridText($model, 'title'),
            'code' => $this->presenter->getGridText($model, 'code'),
            'editable' => $this->presenter->getGridSwitch($model, 'editable'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model, [
                ['view' => 'MinmaxBase::administrator.site-parameter-group.action-button-children', 'uri' => 'site-parameter-item']
            ]),
        ];
    }
}