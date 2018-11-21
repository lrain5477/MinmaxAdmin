<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAdministratorMenuData extends Migration
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
        if ($menuParent = DB::table('administrator_menu')->where('uri', 'control-world')->first()) {
            $menuParentId = $menuParent->id;

            $administratorMenuData = [
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '大洲管理',
                    'uri' => 'world-continent',
                    'controller' => 'WorldContinentController',
                    'model' => 'WorldContinent',
                    'link' => 'world-continent',
                    'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '國家管理',
                    'uri' => 'world-country',
                    'controller' => 'WorldCountryController',
                    'model' => 'WorldCountry',
                    'link' => 'world-country',
                    'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '州區管理',
                    'uri' => 'world-state',
                    'controller' => 'WorldStateController',
                    'model' => 'WorldState',
                    'link' => 'world-state',
                    'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '縣市管理',
                    'uri' => 'world-county',
                    'controller' => 'WorldCountyController',
                    'model' => 'WorldCounty',
                    'link' => 'world-county',
                    'sort' => 5, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '城鎮管理',
                    'uri' => 'world-city',
                    'controller' => 'WorldCityController',
                    'model' => 'WorldCity',
                    'link' => 'world-city',
                    'sort' => 6, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('administrator_menu')->insert($administratorMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['world-continent', 'world-country', 'world-state', 'world-county', 'world-city'];

        DB::table('administrator_menu')->whereIn('uri', $uriSet)->delete();
    }
}
