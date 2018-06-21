<?php

namespace App\Presenters\Administrator;

use App\Models\WorldCountry;

class WorldStatePresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->fieldSelection = [
            'country_id' => WorldCountry::where(['lang' => app()->getLocale()])
                ->orderBy('name')
                ->get(['guid', 'name'])
                ->mapWithKeys(function($item) {
                    /** @var \App\Models\WorldCountry $item **/
                    return [$item->guid => $item->name];
                })
                ->toArray(),
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