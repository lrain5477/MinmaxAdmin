<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SystemSeeder extends Seeder
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

        $languageData = [
            ['guid' => Str::uuid(), 'title' => '繁中', 'codes' => 'tw', 'name' => '繁體中文', 'icon' => 'flag-icon-tw', 'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            //['guid' => Str::uuid(), 'title' => '簡中', 'codes' => 'cn', 'name' => '简体中文', 'icon' => 'flag-icon-cn', 'sort' => 2, 'active' => '0', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            //['guid' => Str::uuid(), 'title' => '英文', 'codes' => 'en', 'name' => 'English', 'icon' => 'flag-icon-us', 'sort' => 3, 'active' => '0', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];
        DB::table('language')->insert($languageData);

        $webData = [
            [
                'guid' => $webDataGuid1 = Str::uuid(),
                'lang' => 'tw',
                'website_key' => 'administrator',
                'website_name' => '總後臺管理系統',
                'system_email' => 'design27@e-creative.tw',
                'system_url' => 'http://minmax.test.la/administrator',
                'company_name' => '雲端數位科技',
                'company_name_en' => 'MinMax',
                'phone' => '04-24350749',
                'fax' => '',
                'email' => 'info@ecreative.tw',
                'address' => '台中市北屯區東山路一段147巷49號',
                'map_lng' => '',
                'map_lat' => '',
                'map_url' => 'https://goo.gl/maps/CRMLfK3xWA62',
                'link_facebook' => '',
                'link_instagram' => '',
                'link_youtube' => '',
                'seo_description' => '',
                'seo_keywords' => '',
                'google_analytics' => '',
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
            [
                'guid' => $webDataGuid2 = Str::uuid(),
                'lang' => 'tw',
                'website_key' => 'admin',
                'website_name' => '後臺管理系統',
                'system_email' => 'design27@e-creative.tw',
                'system_url' => 'http://minmax.test.la/siteadmin',
                'company_name' => '雲端數位科技',
                'company_name_en' => 'MinMax',
                'phone' => '04-24350749',
                'fax' => '',
                'email' => 'info@ecreative.tw',
                'address' => '台中市北屯區東山路一段147巷49號',
                'map_lng' => '',
                'map_lat' => '',
                'map_url' => 'https://goo.gl/maps/CRMLfK3xWA62',
                'link_facebook' => 'https://www.facebook.com/',
                'link_instagram' => 'https://www.instagram.com/',
                'link_youtube' => 'https://www.youtube.com/',
                'seo_description' => '',
                'seo_keywords' => '',
                'google_analytics' => '',
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
            [
                'guid' => $webDataGuid3 = Str::uuid(),
                'lang' => 'tw',
                'website_key' => 'merchant',
                'website_name' => '經銷商管理系統',
                'system_email' => 'design27@e-creative.tw',
                'system_url' => 'http://minmax.test.la/merchant',
                'company_name' => '雲端數位科技',
                'company_name_en' => 'MinMax',
                'phone' => '04-24350749',
                'fax' => '',
                'email' => 'info@ecreative.tw',
                'address' => '台中市北屯區東山路一段147巷49號',
                'map_lng' => '',
                'map_lat' => '',
                'map_url' => 'https://goo.gl/maps/CRMLfK3xWA62',
                'link_facebook' => 'https://www.facebook.com/',
                'link_instagram' => 'https://www.instagram.com/',
                'link_youtube' => 'https://www.youtube.com/',
                'seo_description' => '',
                'seo_keywords' => '',
                'google_analytics' => '',
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
            [
                'guid' => $webDataGuid4 = Str::uuid(),
                'lang' => 'tw',
                'website_key' => 'web',
                'website_name' => '雲端數位科技',
                'system_email' => 'design27@e-creative.tw',
                'system_url' => 'http://minmax.test.la',
                'company_name' => '雲端數位科技',
                'company_name_en' => 'MinMax',
                'phone' => '04-24350749',
                'fax' => '',
                'email' => 'info@ecreative.tw',
                'address' => '台中市北屯區東山路一段147巷49號',
                'map_lng' => '',
                'map_lat' => '',
                'map_url' => 'https://goo.gl/maps/CRMLfK3xWA62',
                'link_facebook' => 'https://www.facebook.com/',
                'link_instagram' => 'https://www.instagram.com/',
                'link_youtube' => 'https://www.youtube.com/',
                'seo_description' => '',
                'seo_keywords' => '',
                'google_analytics' => '',
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
        ];
        DB::table('web_data')->insert($webData);

        foreach ($languageData as $language) {
            if($language['codes'] === $defaultLanguage) continue;
            $languageInsert = collect($webData)->map(function($item, $key) use ($language) {
                $item['lang'] = $language['codes'];
                return $item;
            })->toArray();
            DB::table('web_data')->insert($languageInsert);
        }

        $adminMenuClassData = [
            ['guid' => $menuClassGuid1 = Str::uuid(), 'title' => 'default', 'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['guid' => $menuClassGuid3 = Str::uuid(), 'title' => 'system', 'sort' => 3, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];
        DB::table('admin_menu_class')->insert($adminMenuClassData);

        $adminMenuItemData = [
            [
                'lang' => 'tw',
                'guid' => $menuGuid1 = Str::uuid(),
                'title' => '控制臺',
                'uri' => 'root-command',
                'model' => '',
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
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '經銷商網站基本資訊',
                'uri' => 'merchant-web-data',
                'model' => 'WebData',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid1,
                'link' => 'merchant-web-data/' . $webDataGuid3 . '/edit',
                'icon' => null,
                'permission_key' => 'merchantWebDataEdit',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '前台網站基本資訊',
                'uri' => 'front-web-data',
                'model' => 'WebData',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid1,
                'link' => 'front-web-data/' . $webDataGuid4 . '/edit',
                'icon' => null,
                'permission_key' => 'frontWebDataEdit',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 2,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'lang' => 'tw',
                'guid' => $menuGuid2 = Str::uuid(),
                'title' => '帳戶資訊',
                'uri' => 'root-system-account',
                'model' => '',
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
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '管理員帳戶',
                'uri' => 'admin',
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
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '經銷商帳戶',
                'uri' => 'merchant',
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
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '群組管理',
                'uri' => 'role',
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
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '後台登入紀錄',
                'uri' => 'admin-login-log',
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
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '經銷商登入紀錄',
                'uri' => 'merchant-login-log',
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
                'lang' => 'tw',
                'guid' => $menuGuid3 = Str::uuid(),
                'title' => '資訊安全',
                'uri' => 'root-security',
                'model' => '',
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
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '防火墙',
                'uri' => 'firewall',
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
        ];
        DB::table('admin_menu_item')->insert($adminMenuItemData);

        foreach ($languageData as $language) {
            if($language['codes'] === $defaultLanguage) continue;
            $languageInsert = collect($adminMenuItemData)->map(function($item, $key) use ($language) {
                $item['lang'] = $language['codes'];
                return $item;
            })->toArray();
            DB::table('admin_menu_item')->insert($languageInsert);
        }

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

    }
}
