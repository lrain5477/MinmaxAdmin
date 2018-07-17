<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorldTable extends Migration
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

        // Country / 國家
        Schema::create('world_country', function (Blueprint $table) {
            $table->string('guid', 64);
            $table->string('lang', 100);
            $table->string('title', 128)->comment('國家名稱');
            $table->string('code', 16)->comment('國家代碼');
            $table->string('name', 128)->comment('顯示文字');
            $table->string('icon', 128)->comment('圖示代碼');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();

            $table->primary(['guid', 'lang']);
        });

        // State / County / 州區 / 縣市
        Schema::create('world_state', function (Blueprint $table) {
            $table->string('guid', 64);
            $table->string('lang', 100);
            $table->string('country_id', 64)->comment('國家ID');
            $table->string('title', 128)->comment('州區名稱');
            $table->string('code', 16)->comment('州區代碼');
            $table->string('name', 128)->comment('顯示文字');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();

            $table->primary(['guid', 'lang']);

            $table->foreign(['country_id', 'lang'])->references(['guid', 'lang'])->on('world_country')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // Town / City / 城市 / 鄉鎮市區
        Schema::create('world_city', function (Blueprint $table) {
            $table->string('guid', 64);
            $table->string('lang', 100);
            $table->string('state_id', 60)->comment('州區ID');
            $table->string('title', 128)->comment('城市名稱');
            $table->string('code', 16)->comment('城市代碼');
            $table->string('name', 128)->comment('顯示文字');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();

            $table->primary(['guid', 'lang']);

            $table->foreign(['state_id', 'lang'])->references(['guid', 'lang'])->on('world_state')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 銀行
        Schema::create('bank', function (Blueprint $table) {
            $table->string('guid', 64);
            $table->string('lang', 100);
            $table->string('country_id', 64)->comment('國家ID');
            $table->string('title', 128)->comment('銀行名稱');
            $table->string('code', 16)->comment('銀行代碼');
            $table->string('name', 128)->comment('顯示文字');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();

            $table->primary(['guid', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank');
        Schema::dropIfExists('world_city');
        Schema::dropIfExists('world_state');
        Schema::dropIfExists('world_country');
        Schema::dropIfExists('language');
    }
}
