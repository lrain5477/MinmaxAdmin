<?php

namespace App\Helpers;

class TreeHelper
{
    public static function getMenu($list, $parent = null, $sortKey = 'sort')
    {
        $currentSet = array_values(array_where($list, function ($value) use ($parent) { return is_null($parent) ? is_null($value['parent_id']) : ($value['parent_id'] == $parent); }));

        $currentSet = array_sort($currentSet, function ($value) use ($sortKey, $currentSet) { return $value[$sortKey] ?? count($currentSet); });

        foreach($currentSet as $key => $item) data_fill($currentSet, "{$key}.children", TreeHelper::getMenu($list, $item['guid']));

        if(is_null($parent)) $currentSet = collect($currentSet)->groupBy('class')->toArray();

        return $currentSet;
    }
}