<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrator', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('username', 32)->unique()->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->rememberToken();
            $table->string('name', 100)->nullable()->comment('姓名');
            $table->text('allow_ip')->nullable()->comment('IP白名單');
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
        Schema::dropIfExists('administrator');
    }
}
