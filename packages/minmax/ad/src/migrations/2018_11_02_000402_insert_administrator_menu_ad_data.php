<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAdministratorMenuAdData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 建立預設資料
        $this->insertDatabase();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 刪除預設資料
        $this->deleteDatabase();
    }

    /**
     * Insert default data
     *
     * @return void
     */
    public function insertDatabase()
    {
        $timestamp = date('Y-m-d H:i:s');

        // 管理員選單 - 分類
        if ($menuClassId = DB::table('administrator_menu')->where('uri', 'root-module')->value('id')) {
            $administratorMenuData = [
                [
                    'id' => $menuParentId = uuidl(),
                    'parent_id' => $menuClassId,
                    'title' => '廣告模組',
                    'uri' => 'control-advertising',
                    'controller' => null,
                    'model' => null,
                    'link' => null,
                    'icon' => 'icon-map',
                    'sort' => 207, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '廣告管理',
                    'uri' => 'advertising',
                    'controller' => 'AdvertisingController',
                    'model' => 'Advertising',
                    'link' => 'advertising',
                    'icon' => null,
                    'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '廣告版位',
                    'uri' => 'advertising-category',
                    'controller' => 'AdvertisingCategoryController',
                    'model' => 'AdvertisingCategory',
                    'link' => 'advertising-category',
                    'icon' => null,
                    'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('administrator_menu')->insert($administratorMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-advertising', 'advertising'];

        DB::table('administrator_menu')->whereIn('uri', $uriSet)->delete();
    }
}
