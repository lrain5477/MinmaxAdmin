<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemSeeder::class);
        $this->call(AdministratorSeeder::class);
        //$this->call(RbacSeeder::class);
        //$this->call(ModulesSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
