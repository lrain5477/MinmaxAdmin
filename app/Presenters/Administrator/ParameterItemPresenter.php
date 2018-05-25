<?php

namespace App\Presenters\Administrator;

use App\Models\ParameterGroup;

class ParameterItemPresenter extends Presenter
{
    public function __construct()
    {
        $parameterSet = ParameterGroup::where(['active' => 1])->get(['guid', 'code', 'title']);

        $this->fieldSelection = [
            'active' => $parameterSet->firstWhere('code', '=', 'active')
                ->parameterItem()
                ->where(['active' => 1])
                ->get(['title', 'value'])
                ->mapWithKeys(function($item) {
                    /** @var \App\Models\ParameterItem $item **/
                    return [$item->value => $item->title];
                })
                ->toArray(),
            'group' => ParameterGroup::where(['active' => 1])
                ->get(['guid', 'title'])
                ->mapWithKeys(function($item) {
                    /** @var ParameterGroup $item **/
                    return [$item->guid => $item->title];
                })
                ->toArray(),
        ];
    }
}