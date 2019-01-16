<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class InsertAdminMenuNotifyData extends Migration
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
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'notifyEmail', '事件通知信件', ['R', 'U'], 306));
        DB::table('permissions')->insert($permissionsData);

        // 管理員選單
        if ($menuParentId = DB::table('admin_menu')->where('uri', 'control-configuration')->value('id')) {
            $adminMenuData = [
                [
                    'id' => uuidl(),
                    'title' => '事件通知信件',
                    'uri' => 'notify-email',
                    'controller' => 'NotifyEmailController',
                    'model' => 'NotifyEmail',
                    'parent_id' => $menuParentId,
                    'link' => 'notify-email',
                    'icon' => null,
                    'permission_key' => 'notifyEmailShow',
                    'sort' => 6, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('admin_menu')->insert($adminMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-configuration'];

        DB::table('admin_menu')->whereIn('uri', $uriSet)->delete();

        $permissionSet = ['notifyEmail'];

        DB::table('permissions')->whereIn('group', $permissionSet)->delete();
    }
}
