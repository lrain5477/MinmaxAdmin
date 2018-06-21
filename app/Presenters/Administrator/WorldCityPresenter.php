<?php

namespace App\Presenters\Administrator;

use App\Models\WorldCountry;

class WorldCityPresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->fieldSelection = [
            'state_id' => WorldCountry::where(['lang' => app()->getLocale()])
                ->orderBy('name')
                ->get()
                ->map(function($item) {
                    /** @var \App\Models\WorldCountry $item **/
                    return [
                        'group' => $item->name,
                        'options' => $item
                            ->worldState()
                            ->orderBy('code')
                            ->get(['guid', 'name'])
                            ->mapWithKeys(function($item) {
                                /** @var \App\Models\WorldState $item **/
                                return [$item->guid => $item->name];
                            })
                            ->toArray()
                    ];
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