<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultLanguage = config('app.local');
        $timestamp = date('Y-m-d H:i:s');
        // $languageData = DB::table('world_language')->where('active', '1')->get(['code']);
        $webData = DB::table('web_data')->get(['guid', 'guard']);
        $menuClass = ['default', 'modules', 'system'];

        $adminData = [
            [
                'guid' => Str::uuid(),
                'username' => 'sysadmin',
                'password' => Hash::make('a24252151-A'),
                'name' => '系統管理員',
                'email' => 'info@e-creative.tw',
                'active' => '1',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
            [
                'guid' => $adminGuid = uuidl(),
                'username' => 'admin',
                'password' => Hash::make('24252151'),
                'name' => '系統管理員',
                'email' => 'design27@e-creative.tw',
                'active' => '1',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
        ];
        DB::table('admin')->insert($adminData);

//        $roleUserData = [
//            ['role_id' => '1', 'user_id' => $adminGuid],
//            ['role_id' => '2', 'user_id' => $adminGuid]
//        ];
//        DB::table('role_user')->insert($roleUserData);

        $adminMenuData = [
            [
                'guid' => $menuGuid1 = uuidl(),
                'title' => '控制臺',
                'uri' => 'root-command',
                'controller' => null,
                'model' => null,
                'class' => $menuClass[2],
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-cog',
                'permission_key' => null,
                'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '網站基本資訊',
                'uri' => 'web-data',
                'controller' => 'WebDataController',
                'model' => 'WebData',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid1,
                'link' => 'web-data/' . $webData->where('guard', 'web')->first()->guid . '/edit',
                'icon' => null,
                'permission_key' => 'webDataEdit',
                'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'guid' => $menuGuid2 = uuidl(),
                'title' => '帳戶資訊',
                'uri' => 'root-system-account',
                'controller' => null,
                'model' => null,
                'class' => $menuClass[2],
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-person_pin',
                'permission_key' => null,
                'sort' => 2, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '管理員帳戶',
                'uri' => 'admin',
                'controller' => 'AdminController',
                'model' => 'Admin',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid2,
                'link' => 'admin',
                'icon' => null,
                'permission_key' => 'adminShow',
                'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '群組管理',
                'uri' => 'role',
                'controller' => 'RoleController',
                'model' => 'Role',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid2,
                'link' => 'role',
                'icon' => null,
                'permission_key' => 'roleShow',
                'sort' => 2, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '後臺登入紀錄',
                'uri' => 'login-log',
                'controller' => 'LoginLogController',
                'model' => 'LoginLog',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid2,
                'link' => 'login-log',
                'icon' => null,
                'permission_key' => 'loginLogShow',
                'sort' => 3, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'guid' => $menuGuid3 = uuidl(),
                'title' => '資訊安全',
                'uri' => 'root-security',
                'controller' => null,
                'model' => null,
                'class' => $menuClass[2],
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-shield',
                'permission_key' => null,
                'sort' => 3, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '後臺操作紀錄',
                'uri' => 'system-log',
                'controller' => 'SystemLogController',
                'model' => 'SystemLog',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid3,
                'link' => 'system-log',
                'icon' => null,
                'permission_key' => 'systemLogShow',
                'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '防火墙',
                'uri' => 'firewall',
                'controller' => 'FirewallController',
                'model' => 'Firewall',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid3,
                'link' => 'firewall',
                'icon' => null,
                'permission_key' => 'firewallShow',
                'sort' => 2, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];
        DB::table('admin_menu')->insert($adminMenuData);
    }
}
