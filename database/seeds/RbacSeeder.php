<?php

use App\Helpers\SeederHelper;
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
                'guard' => 'admin', 'group' => 'system',
                'name' => 'systemUpload', 'label' => '上傳', 'display_name' => '系統操作 [上傳]', 'description' => '系統操作 [上傳]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
        ];
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('merchantWebData', '經銷商網站基本資料', ['U']));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('frontWebData', '前台網站基本資料', ['U']));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('editorTemplate', '編輯器模板管理'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', '管理員帳戶'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('merchant', '經銷商帳戶'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('role', '群組管理'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('adminLoginLog', '後台系統登入紀錄', ['R']));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('merchantLoginLog', '經銷商系統登入紀錄', ['R']));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('firewall', '防火牆'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('parameterItem', '參數項目'));
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
