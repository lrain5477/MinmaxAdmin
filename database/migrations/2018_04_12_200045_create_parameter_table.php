<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('code', 32)->unique()->comment('群組代碼');
            $table->string('title', 32)->comment('群組名稱');
            $table->enum('admin', [1, 0])->default(0)->comment('管理權限');     // 1:可用 0:禁止
            $table->enum('active', [1, 0])->default(0)->comment('狀態');  // 1:啟用 0:停用
            $table->timestamps();
        });

        Schema::create('parameter_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('lang', 100);
            $table->string('group', 64)->comment('群組');
            $table->string('title')->comment('標題');
            $table->string('value')->comment('參數值');
            $table->string('class')->nullable()->comment('Class 名稱');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->enum('active', [1, 0])->default(0)->comment('狀態');  // 1:啟用 0:停用
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
        Schema::dropIfExists('parameter_group');
        Schema::dropIfExists('parameter_item');
    }
}
