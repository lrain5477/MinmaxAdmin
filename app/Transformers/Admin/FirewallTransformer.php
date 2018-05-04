<?php

namespace App\Transformers\Admin;

use App\Models\Firewall;

class FirewallTransformer extends Transformer
{
    protected $uri = 'firewall';
    protected $model = 'Firewall';

    public function __construct()
    {
        if(\Auth::guard('admin')->user()->can('firewallShow')) $this->permissions[] = 'R';
        if(\Auth::guard('admin')->user()->can('firewallEdit')) $this->permissions[] = 'U';
        if(\Auth::guard('admin')->user()->can('firewallDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param Firewall $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Firewall $model)
    {
        return [
            'guard' => $this->getGridText($model->guard),
            'ip' => $this->getGridText($model->ip),
            'rule' => $this->getGridSwitch($model->guid, 'rule', $model->rule),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}