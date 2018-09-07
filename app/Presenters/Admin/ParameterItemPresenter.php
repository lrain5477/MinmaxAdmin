<?php

namespace App\Presenters\Admin;

use App\Models\SystemParameter;

class ParameterItemPresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->fieldSelection = [
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
            'group' => SystemParameter::where(['admin' => 1, 'active' => 1])
                ->get(['guid', 'title'])
                ->mapWithKeys(function($item) {
                    /** @var SystemParameter $item **/
                    return [$item->guid => $item->title];
                })
                ->toArray(),
        ];
    }
}