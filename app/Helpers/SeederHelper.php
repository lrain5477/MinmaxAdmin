<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SeederHelper
{
    /**
     * @param string $guard can using 'admin', 'merchant', 'web'
     * @param string $groupName
     * @param string $groupTitle
     * @param array $permissions
     * @return array
     */
    public static function getPermissionArray($guard = 'admin', $groupName, $groupTitle, $permissions = ['C', 'R', 'U', 'D'])
    {
        $timestamp = date('Y-m-d H:i:s');

        $permissionArray = [];

        if(in_array('R', $permissions)) {
            $permissionArray[] = [
                'guard' => $guard, 'group' => $groupName,
                'name' => $groupName . 'Show', 'label' => '瀏覽', 'display_name' => $groupTitle . ' [瀏覽]', 'description' => $groupTitle . ' [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ];
        }

        if(in_array('C', $permissions)) {
            $permissionArray[] = [
                'guard' => $guard, 'group' => $groupName,
                'name' => $groupName . 'Create', 'label' => '新增', 'display_name' => $groupTitle . ' [新增]', 'description' => $groupTitle . ' [新增]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ];
        }

        if(in_array('U', $permissions)) {
            $permissionArray[] = [
                'guard' => $guard, 'group' => $groupName,
                'name' => $groupName . 'Edit', 'label' => '編輯', 'display_name' => $groupTitle . ' [編輯]', 'description' => $groupTitle . ' [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ];
        }

        if(in_array('D', $permissions)) {
            $permissionArray[] = [
                'guard' => $guard, 'group' => $groupName,
                'name' => $groupName . 'Destroy', 'label' => '刪除', 'display_name' => $groupTitle . ' [刪除]', 'description' => $groupTitle . ' [刪除]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ];
        }

        return $permissionArray;
    }

    /**
     * @param array $parameters
     * @param int $adminUse
     * @param string $defaultLanguage
     * @return array
     */
    public static function getParametersArray($parameters, $adminUse = 0, $defaultLanguage = 'tw')
    {
        $timestamp = date('Y-m-d H:i:s');

        $lastRow = \DB::table('parameter_group')->latest('id')->first();
        $currentGuid = is_null($lastRow) ? 1 : ($lastRow->id + 1);

        $parameterSet = [
            'groups' => [],
            'parameters' => []
        ];

        foreach($parameters as $groupCode => $groupItem) {
            if(isset($groupItem['title']) && isset($groupItem['parameters']) && count($groupItem['parameters']) > 0) {
                $groupGuid = $currentGuid++;
                $parameterSet['groups'][] = ['code' => $groupCode, 'title' => $groupItem['title'], 'active' => '1', 'created_at' => $timestamp, 'updated_at' => $timestamp];

                $sortIndex = 1;
                foreach($groupItem['parameters'] as $parameterValue => $parameterItem) {
                    $parameterItem = explode(',', $parameterItem);
                    $parameterLabel = $parameterItem[0] ?? null;
                    $parameterClass = $parameterItem[1] ?? null;
                    $parameterSet['parameters'][] = [
                        'group_id' => $groupGuid, 'label' => $parameterLabel, 'value' => $parameterValue, 'class' => $parameterClass,
                        'sort' => $sortIndex++, 'active' => '1', 'created_at' => $timestamp, 'updated_at' => $timestamp
                    ];
                }
            }
        }

        return $parameterSet;
    }
}