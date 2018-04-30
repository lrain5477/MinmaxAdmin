<?php

namespace App\Presenters\Administrator;

use App\Models\MerchantMenuClass;
use App\Models\MerchantMenuItem;

class MerchantMenuItemPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'active' => [
                '1' => __('models.MerchantMenuItem.selection.active.1'),
                '0' => __('models.MerchantMenuItem.selection.active.0'),
            ],
            'class' => MerchantMenuClass::orderBy('sort')->get(['guid', 'title'])->mapWithKeys(function($item) {
                return [$item->guid => $item->title];
            })->toArray(),
            'parent' => MerchantMenuItem::where(['lang' => app()->getLocale()])->orderByRaw(\DB::raw('parent asc, sort asc'))->get(['guid', 'title', 'parent'])->mapWithKeys(function($item) {
                return [$item->guid => ($item->parent == 0 ? $item->title : ($item->adminMenuItem->title . ' / ' . $item->title))];
            })->prepend('(' . __('administrator.grid.root') . ')', '0')->toArray()
        ];
    }
}