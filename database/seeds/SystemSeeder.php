<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Throwable
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
                'guid' => Str::uuid(),
                'lang' => $defaultLanguage,
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
                'guid' => Str::uuid(),
                'lang' => $defaultLanguage,
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
                'guid' => Str::uuid(),
                'lang' => $defaultLanguage,
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
                'guid' => Str::uuid(),
                'lang' => $defaultLanguage,
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

        try {
            $emailTemplate1 = view('emails.templates.email-normal')->render();
        } catch (\Exception $e) {
            $emailTemplate1 = '';
        }

        $editorTemplateData = [
            [
                'guid' => Str::uuid(),
                'lang' => $defaultLanguage,
                'guard' => 'admin',
                'category' => 'email',
                'title' => '電子郵件-普通',
                'description' => '普通系統訊息通知信件',
                'editor' => $emailTemplate1,
                'sort' => '1',
                'active' => '1',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
        ];
        DB::table('editor_template')->insert($editorTemplateData);
    }
}
