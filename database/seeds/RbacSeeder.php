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
                'guard' => 'admin', 'group' => 'admin',
                'name' => 'adminShow', 'label' => '瀏覽', 'display_name' => '管理員帳號 [瀏覽]', 'description' => '管理員帳號 [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'admin',
                'name' => 'adminCreate', 'label' => '新增', 'display_name' => '管理員帳號 [新增]', 'description' => '管理員帳號 [新增]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'admin',
                'name' => 'adminEdit', 'label' => '編輯', 'display_name' => '管理員帳號 [編輯]', 'description' => '管理員帳號 [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'admin',
                'name' => 'adminDestroy', 'label' => '刪除', 'display_name' => '管理員帳號 [刪除]', 'description' => '管理員帳號 [刪除]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
        ];
        DB::table('permissions')->insert($permissionsData);

        /** 新增權限角色 **/
        $rolesData = [
            [
                'guard' => 'admin', 'name' => 'systemAdmin', 'display_name' => '系統管理員', 'description' => '系統管理員',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
        ];
        DB::table('roles')->insert($rolesData);

        /** 新增權限角色-物件對應 **/
        $permissionRoleData = [];
        foreach($permissionsData as $key => $value) $permissionRoleData[] = ['permission_id' => $key + 1, 'role_id' => 1];
        DB::table('permission_role')->insert($permissionRoleData);
    }
}
