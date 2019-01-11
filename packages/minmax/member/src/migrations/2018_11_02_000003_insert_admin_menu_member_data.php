<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class InsertAdminMenuMemberData extends Migration
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
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'member', '會員資料管理', 241));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'memberTerm', '會員條款', 242));
        DB::table('permissions')->insert($permissionsData);

        // 管理員選單
        if ($menuClass = DB::table('admin_menu')->where('uri', 'root-module')->first()) {
            $adminMenuData = [
                [
                    'id' => $menuParentId = uuidl(),
                    'title' => '會員中心',
                    'uri' => 'control-member',
                    'controller' => null,
                    'model' => null,
                    'parent_id' => $menuClass->id,
                    'link' => null,
                    'icon' => 'icon-users',
                    'permission_key' => null,
                    'sort' => 204, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '會員資料管理',
                    'uri' => 'member',
                    'controller' => 'MemberController',
                    'model' => 'Member',
                    'parent_id' => $menuParentId,
                    'link' => 'member',
                    'icon' => null,
                    'permission_key' => 'memberShow',
                    'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '會員條款',
                    'uri' => 'member-term',
                    'controller' => 'MemberTermController',
                    'model' => 'MemberTerm',
                    'parent_id' => $menuParentId,
                    'link' => 'member-term',
                    'icon' => null,
                    'permission_key' => 'memberTermShow',
                    'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('admin_menu')->insert($adminMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-member', 'member', 'member-term'];

        DB::table('admin_menu')->whereIn('uri', $uriSet)->delete();

        $permissionSet = ['member', 'memberTerm'];

        DB::table('permissions')->whereIn('group', $permissionSet)->delete();
    }
}
