<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrator_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->comment('選單名稱');
            $table->string('uri', 64)->unique()->comment('Uri');
            $table->string('controller', 128)->nullable()->comment('Controller 名稱');
            $table->string('model', 64)->nullable()->comment('Model 名稱');
            $table->string('class', 64)->comment('類別');
            $table->string('parent', 255)->default('0')->comment('上層目錄');
            $table->string('link')->comment('項目連結');    // 根目錄為 javascript:void(0);
            $table->string('icon', 64)->nullable()->comment('圖示 Class');
            $table->string('filter', 255)->nullable()->comment('資料過濾 (where)');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
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
        Schema::dropIfExists('administrator_menu');
    }
}
