<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateLanguageTables extends Migration
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
            $table->string('code', 16)->unique()->comment('語系代碼');
            $table->string('name')->comment('語系名稱');
            $table->string('native')->comment('顯示文字');
            $table->json('options')->comment('語系設定');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active_admin')->default(false)->comment('後臺啟用');
            $table->boolean('active')->default(false)->comment('啟用狀態');
            $table->timestamps();
        });

        // 語言資源表
        Schema::create('language_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('language_id')->comment('語系ID');
            $table->string('key')->comment('鍵值');
            $table->longText('text')->nullable()->comment('內容');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->unique(['language_id', 'key']);

            $table->foreign('language_id')->references('id')->on('world_language')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 建立預設資料
        $this->insertDatabase();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_resource');
        Schema::dropIfExists('world_language');
    }

    /**
     * Insert default data
     *
     * @return void
     */
    public function insertDatabase()
    {
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        // 全球化 - 語言
        $worldLanguageData = [
            [
                'code' => 'zh-Hant',
                'name' => '繁體中文',
                'native' => 'world_language.native.1',
                'options' => json_encode(['icon' => 'flag-icon-tw', 'script' => 'Hant', 'regional' => 'zh_TW']),
                'sort' => 1,
                'active_admin' => true,
                'active' => true,
                'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'code' => 'zh-Hans',
                'name' => '简体中文',
                'native' => 'world_language.native.2',
                'options' => json_encode(['icon' => 'flag-icon-cn', 'script' => 'Hans', 'regional' => 'zh_CN']),
                'sort' => 2,
                'active_admin' => false,
                'active' => false,
                'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'code' => 'ja',
                'name' => '日本語',
                'native' => 'world_language.native.3',
                'options' => json_encode(['icon' => 'flag-icon-jp', 'script' => 'Jpan', 'regional' => 'ja_JP']),
                'sort' => 3,
                'active_admin' => false,
                'active' => false,
                'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'code' => 'en',
                'name' => '英文',
                'native' => 'world_language.native.4',
                'options' => json_encode(['icon' => 'flag-icon-us', 'script' => 'Latn', 'regional' => 'en_US']),
                'sort' => 4,
                'active_admin' => false,
                'active' => false,
                'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
        ];

        DB::table('world_language')->insert($worldLanguageData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_language', [
            ['native' => '繁體中文'], ['native' => '簡體中文'], ['native' => '日本語'], ['native' => '英文']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_language', [
            ['native' => '繁体中文'], ['native' => '简体中文'], ['native' => '日本语'], ['native' => '英文']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_language', [
            ['native' => '中国語 (繁)'], ['native' => '中国語 (簡)'], ['native' => '日本語'], ['native' => '英語']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_language', [
            ['native' => 'Chinese (Traditional)'], ['native' => 'Chinese (Simplified)'], ['native' => 'Japanese'], ['native' => 'English']
        ], 4));

        DB::table('language_resource')->insert($languageResourceData);
    }
}
