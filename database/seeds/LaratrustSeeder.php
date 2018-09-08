<?php

use Illuminate\Database\Seeder;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 新增權限角色-帳號對應 (admin)
        if ($adminModel = \App\Models\Admin::query()->where('username', 'admin')->first()) {
            $adminModel->attachRoles([1, 2]);
        }

        // 新增權限角色-物件對應 (admin)
        if ($roleModel = \App\Models\Role::query()->where(['guard' => 'admin', 'name' => 'systemAdmin'])->first()) {
            $roleModel->attachPermissions(\App\Models\Permission::query()->where('guard', 'admin')->get());
        }
    }
}
