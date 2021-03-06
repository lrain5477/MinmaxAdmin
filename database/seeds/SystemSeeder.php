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
        $timestamp = date('Y-m-d H:i:s');

        $webData = [
            [
                'guid' => $webDataGuid1 = Str::uuid(),
                'lang' => 'tw',
                'website_name' => 'MinMax',
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
                'website_name' => '雲端後台管理系統',
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
                'website_name' => '雲端經銷商管理平台',
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
            [
                'guid' => $webDataGuid4 = Str::uuid(),
                'lang' => 'tw',
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

        $languageData = [
            ['guid' => Str::uuid(), 'title' => '繁中', 'codes' => 'tw', 'name' => '繁體中文', 'icon' => 'flag-icon-tw', 'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['guid' => Str::uuid(), 'title' => '簡中', 'codes' => 'cn', 'name' => '简体中文', 'icon' => 'flag-icon-cn', 'sort' => 2, 'active' => '0', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['guid' => Str::uuid(), 'title' => '英文', 'codes' => 'en', 'name' => 'English', 'icon' => 'flag-icon-us', 'sort' => 3, 'active' => '0', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];
        DB::table('language')->insert($languageData);

        $adminMenuClassData = [
            ['guid' => $menuClassGuid1 = Str::uuid(), 'title' => 'default', 'sort' => 1, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['guid' => $menuClassGuid2 = Str::uuid(), 'title' => 'modules', 'sort' => 2, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['guid' => $menuClassGuid3 = Str::uuid(), 'title' => 'system', 'sort' => 3, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];
        DB::table('admin_menu_class')->insert($adminMenuClassData);

        $adminMenuItemData = [
            [
                'lang' => 'tw',
                'guid' => $menuGuid1 = Str::uuid(),
                'title' => '經銷商系統管理',
                'uri' => 'admin-parent-1',
                'model' => '',
                'class' => $menuClassGuid3,
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-cog',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '網站基本資訊',
                'uri' => 'web-data',
                'model' => 'WebData',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid1,
                'link' => 'web-data/' . $webDataGuid3 . '/edit',
                'icon' => null,
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '防火墙',
                'uri' => 'firewall',
                'model' => 'Firewall',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid1,
                'link' => 'firewall',
                'icon' => null,
                //'filter' => '',
                //'keeps' => '',
                'sort' => 2,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '系統登入紀錄',
                'uri' => 'login-log',
                'model' => 'LoginLog',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid1,
                'link' => 'login-log',
                'icon' => null,
                //'filter' => '',
                //'keeps' => '',
                'sort' => 3,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'lang' => 'tw',
                'guid' => $menuGuid2 = Str::uuid(),
                'title' => '前台系統管理',
                'uri' => 'admin-parent-2',
                'model' => '',
                'class' => $menuClassGuid3,
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-cog',
                //'filter' => '',
                //'keeps' => '',
                'sort' => 2,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'lang' => 'tw',
                'guid' => Str::uuid(),
                'title' => '網站基本資訊',
                'uri' => 'web-data-site',
                'model' => 'WebData',
                'class' => $menuClassGuid3,
                'parent' => $menuGuid2,
                'link' => 'web-data-site/' . $webDataGuid4 . '/edit',
                'icon' => null,
                //'filter' => '',
                //'keeps' => '',
                'sort' => 1,
                'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];
        DB::table('admin_menu_item')->insert($adminMenuItemData);

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
