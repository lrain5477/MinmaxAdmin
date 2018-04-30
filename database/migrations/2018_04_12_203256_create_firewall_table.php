<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirewallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firewall', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('guard', 32)->comment('網站群組');
            $table->string('ip', 39)->comment('IP 位址');
            $table->enum('rule', [1, 0])->default(0)->comment('規則');    // 1:允許 0:禁止
            $table->enum('active', [1, 0])->default(1)->comment('狀態');  // 1:啟用 0:停用
            $table->timestamps();

            $table->unique(['guard', 'ip', 'rule'], 'idx-guard-ip-rule');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firewall');
    }
}
