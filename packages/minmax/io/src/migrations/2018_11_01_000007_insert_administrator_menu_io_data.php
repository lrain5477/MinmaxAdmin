<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAdministratorMenuIoData extends Migration
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
        if ($menuClassId = DB::table('administrator_menu')->where('uri', 'root-system')->value('id')) {
            $menuParentId = DB::table('administrator_menu')->where('uri', 'control-integration')->value('id');

            if (is_null($menuParentId)) {
                $menuParentId = uuidl();
                $administratorMenuData = [
                    [
                        'id' => $menuParentId,
                        'title' => '系統整合',
                        'uri' => 'control-integration',
                        'controller' => null,
                        'model' => null,
                        'parent_id' => $menuClassId,
                        'link' => null,
                        'icon' => 'icon-handshake-o',
                        'sort' => 303, 'updated_at' => $timestamp, 'created_at' => $timestamp
                    ]
                ];
                DB::table('administrator_menu')->insert($administratorMenuData);
            }

            $administratorMenuData = [
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '資料匯入匯出',
                    'uri' => 'io-construct',
                    'controller' => 'IoConstructController',
                    'model' => 'IoConstruct',
                    'link' => 'io-construct',
                    'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('administrator_menu')->insert($administratorMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['io-construct'];

        DB::table('administrator_menu')->whereIn('uri', $uriSet)->delete();
    }
}
