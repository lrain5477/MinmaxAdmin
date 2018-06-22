<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SeederHelper
{
    /**
     * @param string $groupName
     * @param string $groupTitle
     * @param array $permissions
     * @return array
     */
    public static function getPermissionArray($groupName, $groupTitle, $permissions = ['C', 'R', 'U', 'D'])
    {
        $timestamp = date('Y-m-d H:i:s');

        $permissionArray = [];

        if(in_array('R', $permissions)) {
            $permissionArray[] = [
                'guard' => 'admin', 'group' => $groupName,
                'name' => $groupName . 'Show', 'label' => '瀏覽', 'display_name' => $groupTitle . ' [瀏覽]', 'description' => $groupTitle . ' [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ];
        }

        if(in_array('C', $permissions)) {
            $permissionArray[] = [
                'guard' => 'admin', 'group' => $groupName,
                'name' => $groupName . 'Create', 'label' => '新增', 'display_name' => $groupTitle . ' [新增]', 'description' => $groupTitle . ' [新增]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ];
        }

        if(in_array('U', $permissions)) {
            $permissionArray[] = [
                'guard' => 'admin', 'group' => $groupName,
                'name' => $groupName . 'Edit', 'label' => '編輯', 'display_name' => $groupTitle . ' [編輯]', 'description' => $groupTitle . ' [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ];
        }

        if(in_array('D', $permissions)) {
            $permissionArray[] = [
                'guard' => 'admin', 'group' => $groupName,
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

        $parameterSet = [
            'groups' => [],
            'parameters' => []
        ];

        foreach($parameters as $groupCode => $groupItem) {
            if(isset($groupItem['title']) && isset($groupItem['parameters']) && count($groupItem['parameters']) > 0) {
                $groupGuid = Str::uuid();
                $parameterSet['groups'][] = [
                    'guid' => $groupGuid, 'code' => $groupCode, 'title' => $groupItem['title'],
                    'admin' => (string) $adminUse, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
                ];

                $sortIndex = 1;
                foreach($groupItem['parameters'] as $parameterValue => $parameterItem) {
                    $parameterItem = explode(',', $parameterItem);
                    $parameterTitle = $parameterItem[0] ?? null;
                    $parameterClass = $parameterItem[1] ?? null;
                    $parameterSet['parameters'][] = [
                        'guid' => Str::uuid(), 'lang' => $defaultLanguage,
                        'group' => $groupGuid, 'title' => $parameterTitle, 'value' => $parameterValue, 'class' => $parameterClass,
                        'sort' => $sortIndex++, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
                    ];
                }
            }
        }

        return $parameterSet;
    }
}