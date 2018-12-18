<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Firewall;

class FirewallTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'firewallShow',
        'U' => 'firewallEdit',
        'D' => 'firewallDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  WorldContinentPresenter $presenter
     * @param  string $uri
     */
    public function __construct(WorldContinentPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  Firewall $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Firewall $model)
    {
        return [
            'ip' => $this->presenter->getGridText($model, 'ip'),
            'rule' => $this->presenter->getGridSwitch($model, 'rule'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}