<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        /** 新增權限物件 **/
        $permissionsData = [
            [
                'guard' => 'administrator', 'group' => 'adminMenuClass',
                'name' => 'adminMenuClassShow', 'label' => '瀏覽', 'display_name' => '管理員選單類別 [瀏覽]', 'description' => '管理員選單類別 [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'administrator', 'group' => 'adminMenuClass',
                'name' => 'adminMenuClassCreate', 'label' => '新增', 'display_name' => '管理員選單類別 [新增]', 'description' => '管理員選單類別 [新增]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'administrator', 'group' => 'adminMenuClass',
                'name' => 'adminMenuClassEdit', 'label' => '編輯', 'display_name' => '管理員選單類別 [編輯]', 'description' => '管理員選單類別 [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'administrator', 'group' => 'adminMenuClass',
                'name' => 'adminMenuClassDestroy', 'label' => '刪除', 'display_name' => '管理員選單類別 [刪除]', 'description' => '管理員選單類別 [刪除]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
        ];
        DB::table('permissions')->insert($permissionsData);

        /** 新增權限角色 **/
        $rolesData = [
            [
                'guard' => 'administrator', 'name' => 'systemAdmin', 'display_name' => '系統管理員', 'description' => '系統管理員',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
        ];
        DB::table('roles')->insert($rolesData);

        /** 新增權限角色-物件對應 **/
        $permissionRoleData = [
            ['permission_id' => '1', 'role_id' => '1'],
            ['permission_id' => '2', 'role_id' => '1'],
            ['permission_id' => '3', 'role_id' => '1'],
            ['permission_id' => '4', 'role_id' => '1'],
        ];
        DB::table('permission_role')->insert($permissionRoleData);

    }
}
