<?php

namespace App\Presenters\Admin;

class FirewallPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'guard' => [
                'admin' => 'admin',
                'merchant' => 'merchant',
            ],
            'rule' => [
                '1' => __('models.Firewall.selection.rule.1'),
                '0' => __('models.Firewall.selection.rule.0'),
            ],
            'active' => [
                '1' => __('models.Firewall.selection.active.1'),
                '0' => __('models.Firewall.selection.active.0'),
            ],
        ];
    }
}