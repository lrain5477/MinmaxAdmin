<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuClassGuid = Str::uuid();
        $timestamp = date('Y-m-d H:i:s');

        $adminMenuClassData = [
            ['guid' => $menuClassGuid, 'title' => 'modules', 'sort' => 2, 'active' => '1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];
        DB::table('admin_menu_class')->insert($adminMenuClassData);
    }
}
