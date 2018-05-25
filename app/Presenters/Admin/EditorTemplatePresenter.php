<?php

namespace App\Presenters\Admin;

class EditorTemplatePresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->fieldSelection = [
            'guard' => [
                'admin' => 'admin',
                'merchant' => 'merchant',
                'web' => 'web',
            ],
            'active' => $this->parameterSet
                ->firstWhere('code', '=', 'active')
                ->parameterItem()
                ->where(['active' => 1])
                ->get(['title', 'value'])
                ->mapWithKeys(function($item) {
                    /** @var \App\Models\ParameterItem $item **/
                    return [$item->value => $item->title];
                })
                ->toArray(),
        ];
    }
}