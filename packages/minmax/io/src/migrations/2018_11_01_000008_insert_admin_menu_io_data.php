<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class InsertAdminMenuIoData extends Migration
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
        $permissionsData = [
            [
                'guard' => 'admin', 'group' => 'ioData',
                'name' => 'ioDataView', 'label' => '瀏覽', 'display_name' => '資料匯入匯出 [瀏覽]', 'description' => '資料匯入匯出 [瀏覽]',
                'sort' => 371, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'guard' => 'admin', 'group' => 'ioData',
                'name' => 'ioDataImport', 'label' => '匯入', 'display_name' => '資料匯入匯出 [匯入]', 'description' => '資料匯入匯出 [匯入]',
                'sort' => 371, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'guard' => 'admin', 'group' => 'ioData',
                'name' => 'ioDataExport', 'label' => '匯出', 'display_name' => '資料匯入匯出 [匯出]', 'description' => '資料匯入匯出 [匯出]',
                'sort' => 371, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
        ];
        DB::table('permissions')->insert($permissionsData);

        // 管理員選單
        if ($menuClass = DB::table('admin_menu')->where('uri', 'root-system')->first()) {
            $adminMenuData = [
                [
                    'id' => $menuParentId = uuidl(),
                    'title' => '系統整合',
                    'uri' => 'control-integration',
                    'controller' => null,
                    'model' => null,
                    'parent_id' => $menuClass->id,
                    'link' => null,
                    'icon' => 'icon-handshake-o',
                    'permission_key' => null,
                    'sort' => 303, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '資料匯入匯出',
                    'uri' => 'io-data',
                    'controller' => 'IoConstructController',
                    'model' => 'IoConstruct',
                    'parent_id' => $menuParentId,
                    'link' => 'io-data',
                    'icon' => null,
                    'permission_key' => 'ioDataView',
                    'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('admin_menu')->insert($adminMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-integration', 'io-data'];

        DB::table('admin_menu')->whereIn('uri', $uriSet)->delete();
    }
}
