<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\SiteParameterGroup;

/**
 * Class SiteParameterGroupTransformer
 */
class SiteParameterGroupTransformer extends Transformer
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
     * @param  SiteParameterGroup $model
     * @return array
     * @throws \Throwable
     */
    public function transform(SiteParameterGroup $model)
    {
        if (! $model->editable) {
            $this->presenter->setPermissions(array_except($this->permissions, ['U', 'D']));
        }

        $transformerData = [
            'title' => $this->presenter->getGridText($model, 'title'),
            'code' => $this->presenter->getGridText($model, 'code'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];

        $this->presenter->setPermissions($this->permissions);

        return $transformerData;
    }
}