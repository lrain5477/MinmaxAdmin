<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\SystemParameterGroup;

/**
 * Class SystemParameterGroupTransformer
 */
class SystemParameterGroupTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  SystemParameterGroupPresenter $presenter
     * @param  string $uri
     */
    public function __construct(SystemParameterGroupPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  SystemParameterGroup $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SystemParameterGroup $model)
    {
        return [
            'title' => $this->presenter->getGridText($model, 'title'),
            'code' => $this->presenter->getGridText($model, 'code'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model, [
                ['view' => 'MinmaxBase::administrator.system-parameter-group.action-button-children', 'uri' => 'system-parameter-item']
            ]),
        ];
    }
}