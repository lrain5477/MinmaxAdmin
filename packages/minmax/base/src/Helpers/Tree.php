<?php

namespace Minmax\Base\Helpers;

class Tree
{
    /**
     * @param  array $list
     * @param  string|integer $parent
     * @param  string $sortKey
     * @return array
     */
    public static function getMenu($list, $parent = null, $sortKey = 'sort')
    {
        $currentSet = array_values(array_where($list, function ($value) use ($parent) { return is_null($parent) ? is_null($value['parent_id']) : ($value['parent_id'] == $parent); }));

        $currentSet = array_sort($currentSet, function ($value) use ($sortKey, $currentSet) { return $value[$sortKey] ?? count($currentSet); });

        foreach($currentSet as $key => $item) data_fill($currentSet, "{$key}.children", static::getMenu($list, $item['id']));

        return $currentSet;
    }

    /**
     * @param  array $list
     * @param  integer $layer
     * @param  integer $layerLimit
     * @return array
     */
    public static function getList($list, $layer = 1, $layerLimit = 0)
    {
        $result = [];

        if (count($list) > 0 && ($layerLimit == 0 || $layer <= $layerLimit)) {
            foreach ($list as $item) {
                $result[] = array_except($item, 'children') + ['layer' => $layer];
                if (count(array_get($item, 'children', [])) > 0) {
                    $result = array_merge($result, static::getList(array_get($item, 'children', []), $layer + 1, $layerLimit));
                }
            }
        }

        return $result;
    }
}