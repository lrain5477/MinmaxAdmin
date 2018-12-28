<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\SiteParameterItem;

/**
 * Class SiteParameterItemTransformer
 */
class SiteParameterItemTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'siteParameterGroupShow',
        'U' => 'siteParameterGroupEdit',
        'D' => 'siteParameterGroupDestroy',
    ];

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
     * @param  SiteParameterItem $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SiteParameterItem $model)
    {
        if (! $model->siteParameterGroup->editable) {
            $this->presenter->setPermissions(array_except($this->permissions, ['U', 'D']));
        }

        $transformerData = [
            'group_id' => $this->presenter->getGridText($model->siteParameterGroup, 'title'),
            'label' => $this->presenter->getGridText($model, 'label'),
            'value' => $this->presenter->getGridText($model, 'value'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];

        $this->presenter->setPermissions($this->permissions);

        return $transformerData;
    }
}