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
        $defaultLanguage = 'tw';
        $timestamp = date('Y-m-d H:i:s');
        $languageData = DB::select("select codes from `language` where active = '1'");
        $webData = collect(DB::select('select guid, website_key from web_data where lang = ?', [$defaultLanguage]));

        $adminData = [
            [
                'guid' => $adminGuid = Str::uuid(),
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

        $roleUserData = [
            ['role_id' => '1', 'user_id' => $adminGuid],
            ['role_id' => '2', 'user_id' => $adminGuid]
        ];
        DB::table('role_user')->insert($roleUserData);

        $adminMenuClassData = [
            ['guid' => $menuClassGuid1 = Str::uuid(), 'title' => 'default', 'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['guid' => $menuClassGuid3 = Str::uuid(), 'title' => 'system', 'sort' => 3, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];
        DB::table('admin_menu_class')->insert($adminMenuClassData);

        $adminMenuItemData = [
            [
                'lang' => $defaultLanguage,
                'guid' => $menuGuid1 = Str::uuid(),
                'title' => '控制臺',
                'uri' => 'root-command',
                'controller' => null,
                'model' => null,
                'class' => $menuClassGuid3,
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-cog',
                'permission_key' => null,
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '經銷商網站基本資訊',
                'uri' => 'merchant-web-data',
                'controller' => null,
                'model' => 'WebData',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid1,
                'link' => 'merchant-web-data/' . $webData->firstWhere('website_key', 'merchant')->guid . '/edit',
                'icon' => null,
                'permission_key' => 'merchantWebDataEdit',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '前台網站基本資訊',
                'uri' => 'front-web-data',
                'controller' => null,
                'model' => 'WebData',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid1,
                'link' => 'front-web-data/' . $webData->firstWhere('website_key', 'web')->guid . '/edit',
                'icon' => null,
                'permission_key' => 'frontWebDataEdit',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 2,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '編輯器模板管理',
                'uri' => 'editor-template',
                'controller' => null,
                'model' => 'EditorTemplate',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid1,
                'link' => 'editor-template',
                'icon' => null,
                'permission_key' => 'editorTemplateShow',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 3,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'lang' => $defaultLanguage,
                'guid' => $menuGuid2 = Str::uuid(),
                'title' => '帳戶資訊',
                'uri' => 'root-system-account',
                'controller' => null,
                'model' => null,
                'class' => $menuClassGuid3,
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-person_pin',
                'permission_key' => null,
                //'filter' => '',
                //'keeps' => '',
                'sort' => 2,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '管理員帳戶',
                'uri' => 'admin',
                'controller' => 'AdminController',
                'model' => 'Admin',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid2,
                'link' => 'admin',
                'icon' => null,
                'permission_key' => 'adminShow',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '經銷商帳戶',
                'uri' => 'merchant',
                'controller' => 'MerchantController',
                'model' => 'Merchant',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid2,
                'link' => 'merchant',
                'icon' => null,
                'permission_key' => 'merchantShow',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 2,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '群組管理',
                'uri' => 'role',
                'controller' => 'RoleController',
                'model' => 'Role',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid2,
                'link' => 'role',
                'icon' => null,
                'permission_key' => 'roleShow',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 3,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '後台登入紀錄',
                'uri' => 'admin-login-log',
                'controller' => null,
                'model' => 'LoginLog',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid2,
                'link' => 'admin-login-log',
                'icon' => null,
                'permission_key' => 'adminLoginLogShow',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 4,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '經銷商登入紀錄',
                'uri' => 'merchant-login-log',
                'controller' => null,
                'model' => 'LoginLog',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid2,
                'link' => 'merchant-login-log',
                'icon' => null,
                'permission_key' => 'merchantLoginLogShow',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 5,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'lang' => $defaultLanguage,
                'guid' => $menuGuid3 = Str::uuid(),
                'title' => '資訊安全',
                'uri' => 'root-security',
                'controller' => null,
                'model' => null,
                'class' => $menuClassGuid3,
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-shield',
                'permission_key' => null,
                //'filter' => '',
                //'keeps' => '',
                'sort' => 3,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '防火墙',
                'uri' => 'firewall',
                'controller' => null,
                'model' => 'Firewall',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid3,
                'link' => 'firewall',
                'icon' => null,
                'permission_key' => 'firewallShow',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'lang' => $defaultLanguage,
                'guid' => $menuGuid4 = Str::uuid(),
                'title' => '系統參數',
                'uri' => 'root-parameter',
                'controller' => null,
                'model' => null,
                'class' => $menuClassGuid3,
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-filter',
                'permission_key' => null,
                //'filter' => '',
                //'keeps' => '',
                'sort' => 4,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => $defaultLanguage,
                'guid' => Str::uuid(),
                'title' => '參數項目',
                'uri' => 'parameter-item',
                'controller' => 'ParameterItemController',
                'model' => 'ParameterItem',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid4,
                'link' => 'parameter-item',
                'icon' => null,
                'permission_key' => 'parameterItemShow',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];
        DB::table('admin_menu_item')->insert($adminMenuItemData);

        foreach ($languageData as $language) {
            if($language->codes === $defaultLanguage) continue;
            $languageInsert = collect($adminMenuItemData)->map(function($item, $key) use ($language) {
                $item->lang = $language->codes;
                return $item;
            })->toArray();
            DB::table('admin_menu_item')->insert($languageInsert);
        }
    }
}
