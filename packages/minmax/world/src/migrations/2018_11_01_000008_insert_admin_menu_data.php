<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class InsertAdminMenuData extends Migration
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

        // 建立權限物件
        $permissionsData = [];
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'worldContinent', '大洲管理', 381));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'worldCountry', '國家管理', 382));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'worldState', '州區管理', 383));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'worldCounty', '縣市管理', 384));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'worldCity', '城鎮管理', 385));
        DB::table('permissions')->insert($permissionsData);

        // 管理員選單 - 分類
        if ($menuClass = DB::table('admin_menu')->where('uri', 'root-system')->first()) {
            $adminMenuData = [
                [
                    'id' => $menuParentId = uuidl(),
                    'title' => '全球化管理',
                    'uri' => 'control-world',
                    'controller' => null,
                    'model' => null,
                    'parent_id' => $menuClass->id,
                    'link' => null,
                    'icon' => 'icon-sphere',
                    'permission_key' => null,
                    'sort' => 304, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '大洲管理',
                    'uri' => 'world-continent',
                    'controller' => 'WorldContinentController',
                    'model' => 'WorldContinent',
                    'parent_id' => $menuParentId,
                    'link' => 'world-continent',
                    'icon' => null,
                    'permission_key' => 'worldContinentEdit',
                    'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '國家管理',
                    'uri' => 'world-country',
                    'controller' => 'WorldCountryController',
                    'model' => 'WorldCountry',
                    'parent_id' => $menuParentId,
                    'link' => 'world-country',
                    'icon' => null,
                    'permission_key' => 'worldCountryEdit',
                    'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '州區管理',
                    'uri' => 'world-state',
                    'controller' => 'WorldStateController',
                    'model' => 'WorldState',
                    'parent_id' => $menuParentId,
                    'link' => 'world-state',
                    'icon' => null,
                    'permission_key' => 'worldStateEdit',
                    'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '縣市管理',
                    'uri' => 'world-county',
                    'controller' => 'WorldCountyController',
                    'model' => 'WorldCounty',
                    'parent_id' => $menuParentId,
                    'link' => 'world-county',
                    'icon' => null,
                    'permission_key' => 'worldCountyEdit',
                    'sort' => 5, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '城鎮管理',
                    'uri' => 'world-city',
                    'controller' => 'WorldCityController',
                    'model' => 'WorldCity',
                    'parent_id' => $menuParentId,
                    'link' => 'world-city',
                    'icon' => null,
                    'permission_key' => 'worldCityEdit',
                    'sort' => 6, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('admin_menu')->insert($adminMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-world', 'world-continent', 'world-country', 'world-state', 'world-county', 'world-city'];

        DB::table('admin_menu')->whereIn('uri', $uriSet)->delete();
    }
}
