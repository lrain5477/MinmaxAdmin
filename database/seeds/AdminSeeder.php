<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        $adminData = [
            [
                'guid' => $adminGuid = Str::uuid(),
                'username' => 'admin',
                'password' => Hash::make('24252151'),
                'name' => '系統管理員',
                'email' => 'design27@e-creative.tw',
                'active' => '1',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
        ];
        DB::table('admin')->insert($adminData);

        $roleUserData = [
            ['role_id' => '1', 'user_id' => $adminGuid]
        ];
        DB::table('role_user')->insert($roleUserData);
    }
}
