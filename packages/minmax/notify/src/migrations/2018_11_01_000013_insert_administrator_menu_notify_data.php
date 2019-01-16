<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAdministratorMenuNotifyData extends Migration
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
        if ($menuParentId = DB::table('administrator_menu')->where('uri', 'control-configuration')->value('id')) {
            $administratorMenuData = [
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '事件通知信件',
                    'uri' => 'notify-email',
                    'controller' => 'NotifyEmailController',
                    'model' => 'NotifyEmail',
                    'link' => 'notify-email',
                    'icon' => null,
                    'sort' => 7, 'created_at' => $timestamp, 'updated_at' => $timestamp
                ],
            ];
            DB::table('administrator_menu')->insert($administratorMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['notify-email'];

        DB::table('administrator_menu')->whereIn('uri', $uriSet)->delete();
    }
}
