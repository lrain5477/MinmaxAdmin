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
        // 語言
        Schema::create('world_language', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 32)->comment('語系標題');
            $table->string('code', 16)->unique()->comment('語系代碼');
            $table->string('name')->default('world_language.name')->comment('顯示文字');
            $table->string('icon', 128)->comment('圖示代碼');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->enum('active', [1, 0])->default(0)->comment('狀態');
            $table->timestamps();
        });

        // Country / 國家
        Schema::create('world_country', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 128)->comment('國家名稱');
            $table->string('code', 16)->comment('國家代碼');
            $table->string('name')->default('world_country.name')->comment('顯示文字');
            $table->string('icon', 128)->comment('圖示代碼');
            $table->unsignedInteger('language_id')->nullable()->comment('語系ID');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();
        });

        // State / County / 州區 / 縣市
        Schema::create('world_state', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->comment('國家ID');
            $table->string('title', 128)->comment('州區名稱');
            $table->string('code', 16)->comment('州區代碼');
            $table->string('name')->default('world_state.name')->comment('顯示文字');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('world_country')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // Town / City / 城市 / 鄉鎮市區
        Schema::create('world_city', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('state_id')->comment('州區ID');
            $table->string('title', 128)->comment('城市名稱');
            $table->string('code', 16)->comment('城市代碼');
            $table->string('name')->default('world_state.name')->comment('顯示文字');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('world_state')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 語言資源表
        Schema::create('language_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('language_id')->comment('語系ID');
            $table->string('key')->comment('鍵值');
            $table->longText('text')->comment('內容');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->unique(['language_id', 'key']);

            $table->foreign('language_id')->references('id')->on('world_language')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 銀行
        Schema::create('bank', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->comment('國家ID');
            $table->string('title', 128)->comment('銀行名稱');
            $table->string('code', 16)->comment('銀行代碼');
            $table->string('name')->default('bank.name')->comment('顯示文字');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('world_country')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('language_resource');
        Schema::dropIfExists('world_city');
        Schema::dropIfExists('world_state');
        Schema::dropIfExists('world_country');
        Schema::dropIfExists('world_language');
    }
}
