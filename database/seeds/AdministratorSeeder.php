<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        $administratorData = [
            [
                'guid' => Str::uuid(),
                'username' => 'sysadmin',
                'password' => Hash::make('a24252151-A'),
                'name' => '超級管理員',
                'active' => '1',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
        ];
        DB::table('administrator')->insert($administratorData);

        $administratorMenuData = [
            // Default
            [
                'guid' => uuidl(),
                'title' => '系統首頁',
                'uri' => 'home-administrator',
                'controller' => 'SiteController',
                'model' => null,
                'class' => 'default',
                'parent_id' => null,
                'link' => '/',
                'icon' => 'icon-home3',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            // System
            [
                'guid' => $menuGuid1 = uuidl(),
                'title' => '控制臺',
                'uri' => 'root-command-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-cog',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '網站基本資訊',
                'uri' => 'web-data',
                'controller' => 'WebDataController',
                'model' => 'WebData',
                'class' => 'system',
                'parent_id' => $menuGuid1,
                'link' => 'web-data',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '後臺選單目錄',
                'uri' => 'admin-menu',
                'controller' => 'AdminMenuController',
                'model' => 'AdminMenu',
                'class' => 'system',
                'parent_id' => $menuGuid1,
                'link' => 'admin-menu',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '前臺選單目錄',
                'uri' => 'web-menu',
                'controller' => 'WebMenuController',
                'model' => 'WebMenu',
                'class' => 'system',
                'parent_id' => $menuGuid1,
                'link' => 'web-menu',
                'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'guid' => $menuGuid2 = uuidl(),
                'title' => '帳戶資訊',
                'uri' => 'root-account-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-group',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '後臺帳戶管理',
                'uri' => 'admin',
                'controller' => 'AdminController',
                'model' => 'Permission',
                'class' => 'system',
                'parent_id' => $menuGuid2,
                'link' => 'permission',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '權限角色管理',
                'uri' => 'role',
                'controller' => 'RoleController',
                'model' => 'Role',
                'class' => 'system',
                'parent_id' => $menuGuid2,
                'link' => 'role',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '權限物件管理',
                'uri' => 'permission',
                'controller' => 'PermissionController',
                'model' => 'Permission',
                'class' => 'system',
                'parent_id' => $menuGuid2,
                'link' => 'permission',
                'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'guid' => $menuGuid3 = uuidl(),
                'title' => '資訊安全',
                'uri' => 'root-security-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-shield',
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '操作紀錄',
                'uri' => 'firewall',
                'controller' => 'FirewallController',
                'model' => 'Firewall',
                'class' => 'system',
                'parent_id' => $menuGuid3,
                'link' => 'firewall',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '操作紀錄',
                'uri' => 'system-log',
                'controller' => 'SystemLogController',
                'model' => 'SystemLog',
                'class' => 'system',
                'parent_id' => $menuGuid3,
                'link' => 'system-log',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '登入紀錄',
                'uri' => 'login-log',
                'controller' => 'LoginLogController',
                'model' => 'LoginLog',
                'class' => 'system',
                'parent_id' => $menuGuid3,
                'link' => 'login-log',
                'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'guid' => $menuGuid4 = uuidl(),
                'title' => '全球化管理',
                'uri' => 'root-world-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-sphere',
                'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '語系管理',
                'uri' => 'world-language',
                'controller' => 'WorldLanguageController',
                'model' => 'WorldLanguage',
                'class' => 'system',
                'parent_id' => $menuGuid4,
                'link' => 'world-language',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '國家管理',
                'uri' => 'world-country',
                'controller' => 'WorldCountryController',
                'model' => 'WorldCountry',
                'class' => 'system',
                'parent_id' => $menuGuid4,
                'link' => 'world-country',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '行政區域',
                'uri' => 'world-state',
                'controller' => 'WorldStateController',
                'model' => 'WorldState',
                'class' => 'system',
                'parent_id' => $menuGuid4,
                'link' => 'world-state',
                'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '城市管理',
                'uri' => 'world-city',
                'controller' => 'WorldCityController',
                'model' => 'WorldCity',
                'class' => 'system',
                'parent_id' => $menuGuid4,
                'link' => 'world-city',
                'icon' => null,
                'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'guid' => $menuGuid5 = uuidl(),
                'title' => '系統參數',
                'uri' => 'root-parameter-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent_id' => null,
                'link' => null,
                'icon' => 'icon-filter',
                'sort' => 5, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '系統參數管理',
                'uri' => 'system-parameter',
                'controller' => 'SystemParameterController',
                'model' => 'SystemParameter',
                'class' => 'system',
                'parent_id' => $menuGuid5,
                'link' => 'system-parameter',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'guid' => uuidl(),
                'title' => '編輯器模板管理',
                'uri' => 'editor-template',
                'controller' => 'EditorTemplateController',
                'model' => 'EditorTemplate',
                'class' => 'system',
                'parent_id' => $menuGuid5,
                'link' => 'editor-template',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];
        DB::table('administrator_menu')->insert($administratorMenuData);
    }
}
