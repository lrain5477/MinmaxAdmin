<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAdministratorMenuMemberData extends Migration
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
                    'title' => '會員中心',
                    'uri' => 'control-member',
                    'controller' => null,
                    'model' => null,
                    'link' => null,
                    'icon' => 'icon-users',
                    'sort' => 204, 'created_at' => $timestamp, 'updated_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '會員資料管理',
                    'uri' => 'member',
                    'controller' => 'MemberController',
                    'model' => 'Member',
                    'link' => 'member',
                    'icon' => null,
                    'sort' => 1, 'created_at' => $timestamp, 'updated_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '會員條款',
                    'uri' => 'member-term',
                    'controller' => 'MemberTermController',
                    'model' => 'MemberTerm',
                    'link' => 'member-term',
                    'icon' => null,
                    'sort' => 2, 'created_at' => $timestamp, 'updated_at' => $timestamp
                ],
            ];
            DB::table('administrator_menu')->insert($administratorMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-member', 'member', 'member-term'];

        DB::table('administrator_menu')->whereIn('uri', $uriSet)->delete();
    }
}
