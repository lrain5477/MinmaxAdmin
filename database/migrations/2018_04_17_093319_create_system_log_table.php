<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guard', 32)->comment('平台');
            $table->string('uri')->comment('操作網址');
            $table->string('action', 64)->comment('動作');
            $table->text('guid')->comment('項目ID');
            $table->string('username', 255)->comment('帳號');
            $table->string('ip', 39)->comment('IP 位置');
            $table->text('note')->nullable()->comment('文字說明');
            $table->enum('result', [1, 0])->comment('狀態');
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
        Schema::dropIfExists('system_log');
    }
}
