<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertWebMenu();
    }

    protected function insertWebMenu()
    {
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $insertWebMenuData = [
            [
                'id' => $menuRootId1 = uuidl(),
                'parent_id' => null,
                'title' => 'web_menu.title.' . $menuRootId1,
                'uri' => 'root-header',
                'controller' => null,
                'model' => null,
                'link' => null,
                'permission_key' => null,
                'options' => null,
                'sort' => 1, 'editable' => false, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'id' => $menuRootId2 = uuidl(),
                'parent_id' => null,
                'title' => 'web_menu.title.' . $menuRootId2,
                'uri' => 'root-footer',
                'controller' => null,
                'model' => null,
                'link' => null,
                'permission_key' => null,
                'options' => null,
                'sort' => 2, 'editable' => false, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
        ];

        DB::table('web_menu')->insert($insertWebMenuData);

        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('web_menu', [
            ['id' => $menuRootId1, 'title' => '網站主選單'], ['id' => $menuRootId2, 'title' => '頁尾選單']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('web_menu', [
            ['id' => $menuRootId1, 'title' => '网站主选单'], ['id' => $menuRootId2, 'title' => '页尾选单']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('web_menu', [
            ['id' => $menuRootId1, 'title' => 'サイトメニュー'], ['id' => $menuRootId2, 'title' => 'フッターメニュー']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('web_menu', [
            ['id' => $menuRootId1, 'title' => 'Site Main Menu'], ['id' => $menuRootId2, 'title' => 'Footer Menu']
        ], 4));

        DB::table('language_resource')->insert($languageResourceData);
    }
}
