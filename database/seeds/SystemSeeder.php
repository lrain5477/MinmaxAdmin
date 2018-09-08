<?php

use App\Helpers\SeederHelper;
use Illuminate\Database\Seeder;

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
        // $defaultLanguage = config('app.local');
        $timestamp = date('Y-m-d H:i:s');
        $languageAmount = DB::table('world_language')->count();
        $languageResourceData = [];

        $webData = [
            [
                'guid' => uuidl(),
                'guard' => 'administrator',
                'website_name' => '總後臺管理系統',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url') . '/administrator',
                'system_logo' => json_encode([[
                    'path' => 'admin/images/logo-b.png',
                    'alt' => ''
                ]]),
                'company' => json_encode([
                    'name' => '雲端數位科技',
                    'name_en' => 'MinMax',
                    'id' => '24252151'
                ]),
                'contact' => json_encode([
                    'phone' => '04-24350749',
                    'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62',
                    'lng' => '',
                    'lat' => '',
                ]),
                'social' => json_encode([
                    'facebook' => '',
                    'youtube' => '',
                    'instagram' => '',
                ]),
                'seo' => json_encode([
                    'meta_description' => '',
                    'meta_keywords' => '',
                ]),
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'guid' => uuidl(),
                'guard' => 'admin',
                'website_name' => '後臺管理系統',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url') . '/siteadmin',
                'system_logo' => json_encode([[
                    'path' => 'admin/images/logo-b.png',
                    'alt' => ''
                ]]),
                'company' => json_encode([
                    'name' => '雲端數位科技',
                    'name_en' => 'MinMax',
                    'id' => '24252151'
                ]),
                'contact' => json_encode([
                    'phone' => '04-24350749',
                    'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62',
                    'lng' => '',
                    'lat' => '',
                ]),
                'social' => json_encode([
                    'facebook' => 'https://www.facebook.com',
                    'youtube' => 'https://www.youtube.com',
                    'instagram' => 'https://www.instagram.com',
                ]),
                'seo' => json_encode([
                    'meta_description' => '',
                    'meta_keywords' => '',
                ]),
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'guid' => uuidl(),
                'guard' => 'web',
                'website_name' => '後臺管理系統',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url'),
                'system_logo' => json_encode([[
                    'path' => 'admin/images/logo-b.png',
                    'alt' => ''
                ]]),
                'company' => json_encode([
                    'name' => '雲端數位科技',
                    'name_en' => 'MinMax',
                    'id' => '24252151'
                ]),
                'contact' => json_encode([
                    'phone' => '04-24350749',
                    'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62',
                    'lng' => '',
                    'lat' => '',
                ]),
                'social' => json_encode([
                    'facebook' => 'https://www.facebook.com',
                    'youtube' => 'https://www.youtube.com',
                    'instagram' => 'https://www.instagram.com',
                ]),
                'seo' => json_encode([
                    'meta_description' => '',
                    'meta_keywords' => '',
                ]),
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ];

        $languageTempPack = SeederHelper::getExchangeLanguageResource('web_data', $webData, ['company', 'contact', 'seo', 'offline_text'], $languageAmount);
        $webData = $languageTempPack['data'];
        $languageResourceData = array_merge($languageResourceData, $languageTempPack['resource']);

        DB::table('web_data')->insert($webData);

        $parametersData = [
            [
                'code' => 'active',
                'title' => '啟用狀態',
                'options' => json_encode([
                    ['label' => '啟用', 'value' => '1', 'class' => 'danger'],
                    ['label' => '停用', 'value' => '0', 'class' => 'secondary']
                ]),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'code' => 'result',
                'title' => '操作結果',
                'options' => json_encode([
                    ['label' => '成功', 'value' => '1', 'class' => 'success'],
                    ['label' => '失敗', 'value' => '0', 'class' => 'danger']
                ]),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'code' => 'rule',
                'title' => '防火牆規則',
                'options' => json_encode([
                    ['label' => '允許', 'value' => '1', 'class' => 'success'],
                    ['label' => '禁止', 'value' => '0', 'class' => 'danger']
                ]),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ];
        DB::table('system_parameter')->insert($parametersData);

        try {
            $emailTemplate1 = view('emails.templates.email-normal')->render();
        } catch (\Exception $e) {
            $emailTemplate1 = '';
        }

        $editorTemplateData = [
            [
                'guard' => 'admin',
                'category' => 'email',
                'title' => '電子郵件-普通',
                'description' => '普通系統訊息通知信件',
                'editor' => $emailTemplate1,
                'sort' => '1',
                'active' => '1',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ];
        DB::table('editor_template')->insert($editorTemplateData);

        // 儲存語系文件
        DB::table('language_resource')->insert($languageResourceData);
    }
}
