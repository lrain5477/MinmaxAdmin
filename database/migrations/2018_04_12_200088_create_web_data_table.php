<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('lang', 100);
            $table->string('website_key', 16);
            $table->string('website_name', 128)->comment('網站名稱');
            $table->string('system_email')->comment('系統信箱');
            $table->string('system_url')->comment('網站網址');
            $table->string('company_name', 255)->nullable()->comment('公司名稱');
            $table->string('company_name_en', 255)->nullable()->comment('公司英文名稱');
            $table->string('company_id', 32)->nullable()->comment('統一編號');
            $table->string('phone', 100)->nullable()->comment('客服電話');
            $table->string('fax', 100)->nullable()->comment('傳真號碼');
            $table->string('email')->nullable()->comment('客服信箱');
            $table->text('address')->nullable()->comment('公司地址');
            $table->string('map_lng', 16)->nullable()->comment('地圖經度');
            $table->string('map_lat', 16)->nullable()->comment('地圖緯度');
            $table->text('map_url')->nullable()->comment('地圖連結');
            $table->string('link_facebook')->nullable()->comment('Facebook');
            $table->string('link_instagram')->nullable()->comment('Instagram');
            $table->string('link_youtube')->nullable()->comment('Youtube');
            $table->text('seo_description')->nullable()->comment('SEO 網站描述');
            $table->text('seo_keywords')->nullable()->comment('SEO 關鍵字');
            $table->text('google_analytics')->nullable()->comment('Google Analytics');
            $table->enum('active', [1, 0])->default(1)->comment('網站狀態');
            $table->text('offline_text')->nullable()->comment('網站離線訊息');
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
        Schema::dropIfExists('web_data');
    }
}
