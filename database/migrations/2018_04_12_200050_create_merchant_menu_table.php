<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_menu_class', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('title', 255)->comment('類別名稱');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();
        });

        Schema::create('merchant_menu_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('lang', 100);
            $table->string('title', 255)->comment('選單名稱');
            $table->string('uri', 64)->unique()->comment('Uri');
            $table->string('controller', 128)->nullable()->comment('Controller 名稱');
            $table->string('model', 64)->nullable()->comment('Model 名稱');
            $table->string('class', 64)->comment('類別');
            $table->string('parent', 255)->default('0')->comment('上層目錄');
            $table->string('link')->comment('項目連結');    // 根目錄為 javascript:void(0);
            $table->string('icon', 64)->nullable()->comment('圖示 Class');
            $table->string('filter', 255)->nullable()->comment('資料過濾 (where)');
            $table->text('keeps')->nullable()->comment('不可刪除 GUID');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
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
        Schema::dropIfExists('merchant_menu_class');
        Schema::dropIfExists('merchant_menu_item');
    }
}
