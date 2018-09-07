<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menu', function (Blueprint $table) {
            $table->string('guid', 64)->primary();
            $table->string('title', 255)->comment('選單名稱');
            $table->string('uri', 64)->unique()->comment('Uri');
            $table->string('controller', 128)->nullable()->comment('Controller 名稱');
            $table->string('model', 64)->nullable()->comment('Model 名稱');
            $table->string('class', 64)->comment('類別');
            $table->string('parent_id', 64)->nullable()->comment('上層目錄');
            $table->string('link')->nullable()->comment('項目連結');
            $table->string('icon', 64)->nullable()->comment('圖示 Class');
            $table->string('permission_key', 128)->nullable()->comment('權限綁定代碼');
            $table->string('filter', 255)->nullable()->comment('資料過濾 (where)');
            $table->text('keeps')->nullable()->comment('不可刪除 ID');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->string('guid', 64)->primary();
            $table->string('username', 32)->unique()->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->rememberToken();
            $table->string('name', 100)->nullable()->comment('姓名');
            $table->string('email')->nullable()->comment('Email');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');  // 1:啟用 0:停用
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
        Schema::dropIfExists('admin_menu');
    }
}
