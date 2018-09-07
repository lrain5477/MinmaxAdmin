<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 系統參數
        Schema::create('system_parameter', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 32)->unique()->comment('參數代碼');
            $table->string('title', 32)->comment('參數名稱');
            $table->text('options')->nullable()->comment('選項設定');       // {[label, value, class]}
            $table->enum('active', [1, 0])->default(0)->comment('狀態');  // 1:啟用 0:停用
            $table->timestamps();
        });

        // 網站資訊
        Schema::create('web_data', function (Blueprint $table) {
            $table->string('guid', 64)->primary();
            $table->string('guard', 32)->comment('平台');
            $table->string('website_name', 128)->comment('網站名稱');
            $table->string('system_email')->comment('系統信箱');
            $table->string('system_url')->comment('網站網址');
            $table->text('system_logo')->nullable()->comment('網站Logo');
            $table->text('company')->nullable()->comment('公司資訊');   // {name, name_en, id}
            $table->text('contact')->nullable()->comment('聯絡資訊');   // {[phone, fax, email, address, map, lng, lat]}
            $table->text('social')->nullable()->comment('社群連結');    // {facebook, youtube, instagram}
            $table->text('seo')->comment('搜尋引擎');                   // {meta_description, meta_keywords, og_image}
            $table->text('google_analytics')->nullable()->comment('Google Analytics');
            $table->text('offline_text')->nullable()->comment('網站離線訊息');
            $table->enum('active', [1, 0])->default(1)->comment('網站狀態');
            $table->timestamps();
        });

        // 防火牆
        Schema::create('firewall', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guard', 32)->comment('網站群組');
            $table->string('ip', 39)->comment('IP 位址');
            $table->enum('rule', [1, 0])->default(0)->comment('規則');    // 1:允許 0:禁止
            $table->enum('active', [1, 0])->default(1)->comment('狀態');  // 1:啟用 0:停用
            $table->timestamps();

            $table->unique(['guard', 'ip', 'rule'], 'idx-guard-ip-rule');
        });

        // 系統紀錄
        Schema::create('system_log', function (Blueprint $table) {
            $table->string('guard', 32)->comment('平台');
            $table->string('uri')->comment('操作網址');
            $table->string('action', 64)->comment('動作');
            $table->text('guid')->comment('項目ID');
            $table->string('username', 255)->comment('帳號');
            $table->string('ip', 39)->comment('IP 位置');
            $table->text('remark')->nullable()->comment('文字說明');
            $table->enum('result', [1, 0])->comment('狀態');
            $table->timestamp('created_at')->useCurrent();
        });

        // 登入紀錄
        Schema::create('login_log', function (Blueprint $table) {
            $table->string('guard', 32)->comment('平台');
            $table->string('username', 255)->comment('帳號');
            $table->string('ip', 39)->comment('IP 位置');
            $table->text('remark')->nullable()->comment('文字說明');
            $table->enum('result', [1, 0])->comment('狀態');
            $table->timestamp('created_at')->useCurrent();
        });

        // 文字編輯器模板
        Schema::create('editor_template', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guard', 32)->comment('平台');
            $table->string('category', 64)->comment('使用類別');
            $table->string('title', 100)->comment('名稱');
            $table->text('description')->comment('敘述');
            $table->text('editor')->comment('HTML內容');
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
        Schema::dropIfExists('editor_template');
        Schema::dropIfExists('login_log');
        Schema::dropIfExists('system_log');
        Schema::dropIfExists('firewall');
        Schema::dropIfExists('web_data');
        Schema::dropIfExists('system_parameter');
    }
}
