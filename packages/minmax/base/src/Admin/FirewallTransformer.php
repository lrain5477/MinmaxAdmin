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
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        $this->parameterSet = [
            'rule' => systemParam('rule'),
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param Firewall $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Firewall $model)
    {
        return [
            'ip' => $this->getGridText($model->ip),
            'rule' => $this->getGridSwitch($model->id, 'rule', $model->rule),
            'active' => $this->getGridSwitch($model->id, 'active', $model->active),
            'action' => $this->getGridActions($model->id),
        ];
    }
}