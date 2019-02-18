<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateLaratrustTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guard', 16);
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guard', 16);
            $table->string('group');
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('sort')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Create table for associating roles to users and teams (Many To Many Polymorphic)
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->string('user_id', 64);
            $table->string('user_type');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id', 'user_type']);
        });

        // Create table for associating permissions to users (Many To Many Polymorphic)
        Schema::create('permission_user', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->string('user_id', 64);
            $table->string('user_type');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'permission_id', 'user_type']);
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

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
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }

    /**
     * Insert default data
     *
     * @return void
     */
    public function insertDatabase()
    {
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        // 新增權限角色
        $rolesData = [
            [
                'guard' => 'admin', 'name' => 'systemAdmin', 'display_name' => 'roles.display_name.1',
                'description' => 'roles.description.1', 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
        ];
        DB::table('roles')->insert($rolesData);

        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('roles', [
            ['display_name' => '系統管理員', 'description' => '系統管理員']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('roles', [
            ['display_name' => '系统管理员', 'description' => '系统管理员']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('roles', [
            ['display_name' => 'システム管理者', 'description' => 'システム管理者']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('roles', [
            ['display_name' => 'System Admin', 'description' => 'System admin manager']
        ], 4));

        DB::table('language_resource')->insert($languageResourceData);
    }
}
