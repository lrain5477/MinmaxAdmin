<?php

namespace App\Transformers\Admin;

use App\Models\Firewall;

class FirewallTransformer extends Transformer
{
    protected $model = 'Firewall';
    protected $parameterSet = [
        'rule', 'active',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(request()->user('admin')->can('firewallShow')) $this->permissions[] = 'R';
        if(request()->user('admin')->can('firewallEdit')) $this->permissions[] = 'U';
        if(request()->user('admin')->can('firewallDestroy')) $this->permissions[] = 'D';
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