<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('title', 32)->comment('語系');
            $table->string('codes', 16)->comment('語系代碼');
            $table->string('name', 32)->comment('顯示文字');
            $table->string('icon', 128)->comment('圖示代碼');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->enum('active', [1, 0])->default(0)->comment('狀態');
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
        Schema::dropIfExists('language');
    }
}
