<?php

namespace App\Presenters\Administrator;

use App\Models\ParameterGroup;

class ParameterGroupPresenter extends Presenter
{
    public function __construct()
    {
        $parameterSet = ParameterGroup::where(['active' => 1])->get(['guid', 'code', 'title']);

        $this->fieldSelection = [
            'admin' => $parameterSet->firstWhere('code', '=', 'admin')
                ->parameterItem()
                ->where(['active' => 1])
                ->get(['title', 'value'])
                ->mapWithKeys(function($item) {
                    /** @var \App\Models\ParameterItem $item **/
                    return [$item->value => $item->title];
                })
                ->toArray(),
            'active' => $parameterSet->firstWhere('code', '=', 'active')
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