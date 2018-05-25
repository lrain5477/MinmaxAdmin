<?php

namespace App\Presenters\Administrator;

use App\Models\MerchantMenuClass;
use App\Models\MerchantMenuItem;

class MerchantMenuItemPresenter extends Presenter
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
            'class' => MerchantMenuClass::orderBy('sort')->get(['guid', 'title'])->mapWithKeys(function($item) {
                return [$item->guid => $item->title];
            })->toArray(),
            'parent' => MerchantMenuItem::where(['lang' => app()->getLocale()])->orderByRaw(\DB::raw('parent asc, sort asc'))->get(['guid', 'title', 'parent'])->mapWithKeys(function($item) {
                return [$item->guid => ($item->parent == 0 ? $item->title : ($item->adminMenuItem->title . ' / ' . $item->title))];
            })->prepend('(' . __('administrator.grid.root') . ')', '0')->toArray()
        ];
    }
}