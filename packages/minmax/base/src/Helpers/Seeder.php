<?php

namespace Minmax\Base\Helpers;

class Seeder
{
    /**
     * @param  string $table
     * @param  array $dataSet
     * @param  array|string $columns
     * @param  int $languageAmount
     * @return array
     */
    public static function getExchangeLanguageResource($table, $dataSet, $columns, $languageAmount = 1)
    {
        $timestamp    = date('Y-m-d H:i:s');
        $columns      = is_array($columns) ? $columns : [$columns];
        $resourceData = [];

        foreach ($dataSet as $key => $item) {
            $keyId = $item['guid'] ?? ($key + 1);
            foreach ($columns as $column) {
                for ($id = 1; $id <= $languageAmount; $id++) {
                    array_push($resourceData, [
                        'language_id' => $id,
                        'key' => $table . '.' . $column . '.' . $keyId,
                        'text' => $item[$column] ?? '',
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp
                    ]);
                }
                $dataSet[$key][$column] = $table . '.' . $column . '.' . $keyId;
            }
        }

        return ['data' => $dataSet ?? [], 'resource' => $resourceData ?? []];
    }

    /**
     * @param  string $table
     * @param  array $dataSet
     * @param  int $language
     * @param  int $start
     * @return array
     */
    public static function getLanguageResourceArray($table, $dataSet, $language = 1, $start = 1)
    {
        $timestamp = date('Y-m-d H:i:s');
        $resourceData = [];

        foreach ($dataSet as $key => $attributes) {
            $index = $attributes['id'] ?? ($key + $start);
            foreach (array_except($attributes, 'id') as $column => $text) {
                $thisKey = "{$table}.{$column}.{$index}";
                array_push($resourceData, [
                    'language_id' => $language,
                    'key' => $thisKey,
                    'text' => $text,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ]);
            }
        }

        return $resourceData;
    }

    /**
     * @param  string $guard can using 'admin', 'web'
     * @param  string $groupName
     * @param  string $groupTitle
     * @param  array $permissions
     * @param  integer $sort
     * @return array
     */
    public static function getPermissionArray($guard, $groupName, $groupTitle, $permissions = ['C', 'R', 'U', 'D'], $sort = 1)
    {
        $timestamp       = date('Y-m-d H:i:s');
        $permissionArray = [];

        if (is_int($permissions)) {
            $sort = $permissions;
            $permissions = ['C', 'R', 'U', 'D'];
        }

        if(in_array('R', $permissions)) {
            $permissionArray[] = [
                'guard' => $guard, 'group' => $groupName,
                'name' => $groupName . 'Show', 'label' => '瀏覽', 'display_name' => $groupTitle . ' [瀏覽]', 'description' => $groupTitle . ' [瀏覽]',
                'sort' => $sort, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ];
        }

        if(in_array('C', $permissions)) {
            $permissionArray[] = [
                'guard' => $guard, 'group' => $groupName,
                'name' => $groupName . 'Create', 'label' => '新增', 'display_name' => $groupTitle . ' [新增]', 'description' => $groupTitle . ' [新增]',
                'sort' => $sort, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ];
        }

        if(in_array('U', $permissions)) {
            $permissionArray[] = [
                'guard' => $guard, 'group' => $groupName,
                'name' => $groupName . 'Edit', 'label' => '編輯', 'display_name' => $groupTitle . ' [編輯]', 'description' => $groupTitle . ' [編輯]',
                'sort' => $sort, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ];
        }

        if(in_array('D', $permissions)) {
            $permissionArray[] = [
                'guard' => $guard, 'group' => $groupName,
                'name' => $groupName . 'Destroy', 'label' => '刪除', 'display_name' => $groupTitle . ' [刪除]', 'description' => $groupTitle . ' [刪除]',
                'sort' => $sort, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ];
        }

        return $permissionArray;
    }
}