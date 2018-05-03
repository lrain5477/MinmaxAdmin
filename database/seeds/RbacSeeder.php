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
                'guard' => 'admin', 'group' => 'merchantWebData',
                'name' => 'merchantWebDataEdit', 'label' => '編輯', 'display_name' => '經銷商網站基本資料 [編輯]', 'description' => '經銷商網站基本資料 [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'frontWebData',
                'name' => 'frontWebDataEdit', 'label' => '編輯', 'display_name' => '前台網站基本資料 [編輯]', 'description' => '前台網站基本資料 [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],

            [
                'guard' => 'admin', 'group' => 'admin',
                'name' => 'adminShow', 'label' => '瀏覽', 'display_name' => '管理員帳戶 [瀏覽]', 'description' => '管理員帳戶 [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'admin',
                'name' => 'adminCreate', 'label' => '新增', 'display_name' => '管理員帳戶 [新增]', 'description' => '管理員帳戶 [新增]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'admin',
                'name' => 'adminEdit', 'label' => '編輯', 'display_name' => '管理員帳戶 [編輯]', 'description' => '管理員帳戶 [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'admin',
                'name' => 'adminDestroy', 'label' => '刪除', 'display_name' => '管理員帳戶 [刪除]', 'description' => '管理員帳戶 [刪除]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'merchant',
                'name' => 'merchantShow', 'label' => '瀏覽', 'display_name' => '經銷商帳戶 [瀏覽]', 'description' => '經銷商帳戶 [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'merchant',
                'name' => 'merchantCreate', 'label' => '新增', 'display_name' => '經銷商帳戶 [新增]', 'description' => '經銷商帳戶 [新增]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'merchant',
                'name' => 'merchantEdit', 'label' => '編輯', 'display_name' => '經銷商帳戶 [編輯]', 'description' => '經銷商帳戶 [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'merchant',
                'name' => 'merchantDestroy', 'label' => '刪除', 'display_name' => '經銷商帳戶 [刪除]', 'description' => '經銷商帳戶 [刪除]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'role',
                'name' => 'roleShow', 'label' => '瀏覽', 'display_name' => '群組管理 [瀏覽]', 'description' => '群組管理 [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'role',
                'name' => 'roleCreate', 'label' => '新增', 'display_name' => '群組管理 [新增]', 'description' => '群組管理 [新增]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'role',
                'name' => 'roleEdit', 'label' => '編輯', 'display_name' => '群組管理 [編輯]', 'description' => '群組管理 [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'role',
                'name' => 'roleDestroy', 'label' => '刪除', 'display_name' => '群組管理 [刪除]', 'description' => '群組管理 [刪除]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'adminLoginLog',
                'name' => 'adminLoginLogShow', 'label' => '瀏覽', 'display_name' => '後台系統登入紀錄 [瀏覽]', 'description' => '後台系統登入紀錄 [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'merchantLoginLog',
                'name' => 'merchantLoginLogShow', 'label' => '瀏覽', 'display_name' => '經銷商系統登入紀錄 [瀏覽]', 'description' => '經銷商系統登入紀錄 [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],

            [
                'guard' => 'admin', 'group' => 'firewall',
                'name' => 'firewallShow', 'label' => '瀏覽', 'display_name' => '防火牆 [瀏覽]', 'description' => '防火牆 [瀏覽]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'firewall',
                'name' => 'firewallCreate', 'label' => '新增', 'display_name' => '防火牆 [新增]', 'description' => '防火牆 [新增]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'firewall',
                'name' => 'firewallEdit', 'label' => '編輯', 'display_name' => '防火牆 [編輯]', 'description' => '防火牆 [編輯]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'group' => 'firewall',
                'name' => 'firewallDestroy', 'label' => '刪除', 'display_name' => '防火牆 [刪除]', 'description' => '防火牆 [刪除]',
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
