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
        $this->call(WorldSeeder::class);
        $this->call(SystemSeeder::class);
        $this->call(AdministratorSeeder::class);
        $this->call(AdminSeeder::class);
        //$this->call(ProjectSeeder::class);
        $this->call(LaratrustSeeder::class);
    }
}
