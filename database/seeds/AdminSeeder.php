<?php

use App\Helpers\SeederHelper;
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
        // $defaultLanguage = config('app.local');
        $timestamp = date('Y-m-d H:i:s');
        $webData = DB::table('web_data')->get(['guid', 'guard']);
        $menuClass = ['default', 'module', 'system'];

        $adminData = [
            [
                'guid' => Str::uuid(),
                'username' => 'sysadmin',
                'password' => Hash::make('a24252151-A'),
                'name' => '超級管理員',
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

        // 新增權限角色
        $rolesData = [
            [
                'guard' => 'admin', 'name' => 'systemAdmin', 'display_name' => '系統管理員',
                'description' => '系統管理員', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
            [
                'guard' => 'admin', 'name' => 'systemEmail', 'display_name' => '信件接收',
                'description' => '此群組無特別權限，該群組成員可收到系統信。', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
        ];
        DB::table('roles')->insert($rolesData);

        // 建立權限物件
        $permissionsData = [
            [
                'guard' => 'admin', 'group' => 'system',
                'name' => 'systemUpload', 'label' => '上傳', 'display_name' => '系統操作 [上傳]', 'description' => '系統操作 [上傳]',
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp,
            ],
        ];
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'webData', '網站基本資訊', ['U']));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'newsletterSchedule', '電子報管理'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'newsletterTemplate', '電子報範本'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'newsletterSubscribe', '電子報名單', ['R', 'D']));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'newsletterGroup', '電子報類別'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'admin', '管理員帳戶'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'role', '群組管理'));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'loginLog', '後臺登入紀錄', ['R']));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'systemLog', '後臺操作紀錄', ['R']));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'firewall', '防火牆'));
        DB::table('permissions')->insert($permissionsData);

        $adminMenuData = [
            // Default
            [
                'guid' => uuidl(),
                'title' => '系統首頁',
                'uri' => 'home-admin',
                'controller' => 'SiteController',
                'model' => null,
                'class' => $menuClass[0],
                'parent_id' => null,
                'link' => '/',
                'icon' => 'icon-home3',
                'permission_key' => null,
                'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '前臺首頁',
                'uri' => 'home-web',
                'controller' => null,
                'model' => null,
                'class' => $menuClass[0],
                'parent_id' => null,
                'link' => config('app.url'),
                'icon' => 'icon-home3',
                'permission_key' => null,
                'sort' => 2, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            // Module
            // TODO: Put project menu here.

            [
                'guid' => $menuGuid1 = uuidl(),
                'title' => '電子報',
                'uri' => 'root-newsletter',
                'controller' => null,
                'model' => null,
                'class' => $menuClass[1],
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-newspaper',
                'permission_key' => null,
                'sort' => 10, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '電子報管理',
                'uri' => 'newsletter-schedule',
                'controller' => 'NewsletterScheduleController',
                'model' => 'NewsletterSchedule',
                'class' => $menuClass[1],
                'parent_id' => $menuGuid1,
                'link' => 'newsletter-schedule',
                'icon' => null,
                'permission_key' => 'newsletterScheduleShow',
                'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '範本管理',
                'uri' => 'newsletter-template',
                'controller' => 'NewsletterTemplateController',
                'model' => 'NewsletterTemplate',
                'class' => $menuClass[1],
                'parent_id' => $menuGuid1,
                'link' => 'newsletter-template',
                'icon' => null,
                'permission_key' => 'newsletterTemplateShow',
                'sort' => 2, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '名單管理',
                'uri' => 'newsletter-subscribe',
                'controller' => 'NewsletterSubscribeController',
                'model' => 'NewsletterSubscribe',
                'class' => $menuClass[1],
                'parent_id' => $menuGuid1,
                'link' => 'newsletter-subscribe',
                'icon' => null,
                'permission_key' => 'newsletterSubscribeShow',
                'sort' => 3, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '發報類別',
                'uri' => 'newsletter-group',
                'controller' => 'NewsletterGroupController',
                'model' => 'NewsletterGroup',
                'class' => $menuClass[1],
                'parent_id' => $menuGuid1,
                'link' => 'newsletter-group',
                'icon' => null,
                'permission_key' => 'newsletterGroupShow',
                'sort' => 4, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            // System
            [
                'guid' => $menuGuid2 = uuidl(),
                'title' => '控制臺',
                'uri' => 'root-command',
                'controller' => null,
                'model' => null,
                'class' => $menuClass[2],
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-cog',
                'permission_key' => null,
                'sort' => 11, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '網站基本資訊',
                'uri' => 'web-data',
                'controller' => 'WebDataController',
                'model' => 'WebData',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid2,
                'link' => 'web-data/' . $webData->where('guard', 'web')->first()->guid . '/edit',
                'icon' => null,
                'permission_key' => 'webDataEdit',
                'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'guid' => $menuGuid3 = uuidl(),
                'title' => '帳戶資訊',
                'uri' => 'root-system-account',
                'controller' => null,
                'model' => null,
                'class' => $menuClass[2],
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-person_pin',
                'permission_key' => null,
                'sort' => 12, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '管理員帳戶',
                'uri' => 'admin',
                'controller' => 'AdminController',
                'model' => 'Admin',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid3,
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
                'parent_id' => $menuGuid3,
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
                'parent_id' => $menuGuid3,
                'link' => 'login-log',
                'icon' => null,
                'permission_key' => 'loginLogShow',
                'sort' => 3, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'guid' => $menuGuid4 = uuidl(),
                'title' => '資訊安全',
                'uri' => 'root-security',
                'controller' => null,
                'model' => null,
                'class' => $menuClass[2],
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-shield',
                'permission_key' => null,
                'sort' => 13, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '後臺操作紀錄',
                'uri' => 'system-log',
                'controller' => 'SystemLogController',
                'model' => 'SystemLog',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid4,
                'link' => 'system-log',
                'icon' => null,
                'permission_key' => 'systemLogShow',
                'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '防火牆',
                'uri' => 'firewall',
                'controller' => 'FirewallController',
                'model' => 'Firewall',
                'class' => $menuClass[2],
                'parent_id' => $menuGuid4,
                'link' => 'firewall',
                'icon' => null,
                'permission_key' => 'firewallShow',
                'sort' => 2, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];
        DB::table('admin_menu')->insert($adminMenuData);
    }
}
