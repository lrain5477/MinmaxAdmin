<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class InsertPermissionRoleData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // 建立預設資料
        $this->insertDatabase();
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
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
        //$timestamp = date('Y-m-d H:i:s');

        // 新增權限角色-物件對應 (admin)
        if ($roleModel = \Minmax\Base\Models\Role::query()->where(['guard' => 'admin', 'name' => 'systemAdmin'])->first()) {
            $roleModel->attachPermissions(\Minmax\Base\Models\Permission::query()->where('guard', 'admin')->get());
        }
    }

    public function deleteDatabase()
    {
        DB::table('permission_role')->delete();
    }
}
