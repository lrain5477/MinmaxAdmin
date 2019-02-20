<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class InsertAdminMenuAdData extends Migration
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
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'advertising', '廣告管理', 271));
        DB::table('permissions')->insert($permissionsData);

        // 管理員選單
        if ($menuClassId = DB::table('admin_menu')->where('uri', 'root-module')->value('id')) {
            $adminMenuData = [
                [
                    'id' => $menuParentId = uuidl(),
                    'title' => '廣告模組',
                    'uri' => 'control-advertising',
                    'controller' => null,
                    'model' => null,
                    'parent_id' => $menuClassId,
                    'link' => null,
                    'icon' => 'icon-map',
                    'permission_key' => null,
                    'sort' => 207, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '廣告管理',
                    'uri' => 'advertising',
                    'controller' => 'AdvertisingController',
                    'model' => 'Advertising',
                    'parent_id' => $menuParentId,
                    'link' => 'advertising',
                    'icon' => null,
                    'permission_key' => 'advertisingShow',
                    'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('admin_menu')->insert($adminMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-advertising', 'advertising'];

        DB::table('admin_menu')->whereIn('uri', $uriSet)->delete();
    }
}
