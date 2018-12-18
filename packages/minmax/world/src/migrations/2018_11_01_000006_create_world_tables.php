<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateWorldTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Continent / 大洲
        Schema::create('world_continent', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 128)->comment('大洲名稱');
            $table->string('code', 16)->comment('大洲代碼');
            $table->string('name')->comment('顯示文字');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('狀態');
            $table->timestamps();
        });

        // Country / 國家
        Schema::create('world_country', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('continent_id')->comment('大洲ID');
            $table->string('title', 128)->comment('國家名稱');
            $table->string('code', 16)->comment('國家代碼');
            $table->string('name')->comment('顯示文字');
            $table->string('icon', 128)->nullable()->comment('圖示代碼');
            $table->unsignedInteger('language_id')->nullable()->comment('語系ID');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('狀態');
            $table->timestamps();

            $table->foreign('continent_id')->references('id')->on('world_continent')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // State / 州區
        Schema::create('world_state', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->comment('國家ID');
            $table->string('title', 128)->comment('州區名稱');
            $table->string('code', 16)->comment('州區代碼');
            $table->string('name')->comment('顯示文字');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('狀態');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('world_country')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // County / 縣市郡
        Schema::create('world_county', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('state_id')->comment('州區ID');
            $table->string('title', 128)->comment('縣市名稱');
            $table->string('code', 16)->comment('縣市代碼');
            $table->string('name')->comment('顯示文字');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('狀態');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('world_state')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // City / 鄉鎮市區
        Schema::create('world_city', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('county_id')->comment('縣市ID');
            $table->string('title', 128)->comment('城市名稱');
            $table->string('code', 16)->comment('城市代碼');
            $table->string('name')->comment('顯示文字');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('狀態');
            $table->timestamps();

            $table->foreign('county_id')->references('id')->on('world_county')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 銀行
        Schema::create('world_bank', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->comment('國家ID');
            $table->string('title', 128)->comment('銀行名稱');
            $table->string('code', 16)->comment('銀行代碼');
            $table->string('name')->comment('顯示文字');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('狀態');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('world_country')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 貨幣
        Schema::create('world_currency', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 128)->comment('貨幣名稱');
            $table->string('code', 16)->comment('貨幣代碼');
            $table->string('name')->comment('顯示文字');
            $table->json('options')->comment('貨幣設定');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('狀態');
            $table->timestamps();
        });

        Schema::table('world_language', function (Blueprint $table) {
            $table->unsignedInteger('currency_id')->default(1)->after('options')->comment('貨幣ID');
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
        Schema::table('world_language', function (Blueprint $table) {
            $table->dropColumn('currency_id');
        });

        Schema::dropIfExists('world_currency');
        Schema::dropIfExists('world_bank');
        Schema::dropIfExists('world_city');
        Schema::dropIfExists('world_county');
        Schema::dropIfExists('world_state');
        Schema::dropIfExists('world_country');
        Schema::dropIfExists('world_continent');
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

        // 全球化 - 大洲
        $worldContinentData = [
            ['title' => '亞洲', 'code' => 'AS', 'name' => 'world_continent.name.1', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '北美洲', 'code' => 'NA', 'name' => 'world_continent.name.2', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '南美洲', 'code' => 'SA', 'name' => 'world_continent.name.3', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '歐洲', 'code' => 'EU', 'name' => 'world_continent.name.4', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '非洲', 'code' => 'AF', 'name' => 'world_continent.name.5', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '大洋洲', 'code' => 'OC', 'name' => 'world_continent.name.6', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '南極洲', 'code' => 'AN', 'name' => 'world_continent.name.7', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        DB::table('world_continent')->insert($worldContinentData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_continent', [
            ['name' => '亞洲'], ['name' => '北美洲'], ['name' => '南美洲'], ['name' => '歐洲'], ['name' => '非洲'], ['name' => '大洋洲'], ['name' => '南極洲']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_continent', [
            ['name' => '亞洲'], ['name' => '北美洲'], ['name' => '南美洲'], ['name' => '欧洲'], ['name' => '非洲'], ['name' => '大洋洲'], ['name' => '南极洲']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_continent', [
            ['name' => 'アジア'], ['name' => '北米'], ['name' => '南米'], ['name' => 'ヨーロッパ'], ['name' => 'アフリカ'], ['name' => 'オセアニア'], ['name' => '南极洲']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_continent', [
            ['name' => 'Asia'], ['name' => 'North America'], ['name' => 'South America'], ['name' => 'Europe'], ['name' => 'Africa'], ['name' => 'Oceania'], ['name' => 'Antarctica']
        ], 4));

        // 全球化 - 國家
        $worldCountryData = [
            ['continent_id' => 1, 'title' => '臺灣', 'code' => 'TW', 'name' => 'world_country.name.1', 'icon' => 'flag-icon-tw', 'language_id' => 1, 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        DB::table('world_country')->insert($worldCountryData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_country', [
            ['name' => '臺灣']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_country', [
            ['name' => '台湾']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_country', [
            ['name' => '台湾']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_country', [
            ['name' => 'Taiwan']
        ], 4));

        // 全球化 - 州區
        $worldStateData = [
            ['country_id' => 1, 'title' => '北部', 'code' => 'North', 'name' => 'world_state.name.1', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['country_id' => 1, 'title' => '中部', 'code' => 'West', 'name' => 'world_state.name.2', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['country_id' => 1, 'title' => '南部', 'code' => 'South', 'name' => 'world_state.name.3', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['country_id' => 1, 'title' => '東部', 'code' => 'East', 'name' => 'world_state.name.4', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['country_id' => 1, 'title' => '外島', 'code' => 'Island', 'name' => 'world_state.name.5', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        DB::table('world_state')->insert($worldStateData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_state', [
            ['name' => '北部'], ['name' => '中部'], ['name' => '南部'], ['name' => '東部'], ['name' => '外島']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_state', [
            ['name' => '北部'], ['name' => '中部'], ['name' => '南部'], ['name' => '东部'], ['name' => '外岛']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_state', [
            ['name' => '北部'], ['name' => '中部'], ['name' => '南部'], ['name' => '東部'], ['name' => '外の島']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_state', [
            ['name' => 'North'], ['name' => 'West'], ['name' => 'South'], ['name' => 'East'], ['name' => 'Outer Island']
        ], 4));

        // 全球化 - 州區
        $worldCountyData = [
            ['state_id' => 1, 'title' => '基隆市', 'code' => 'TW-KL', 'name' => 'world_county.name.1', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '臺北市', 'code' => 'TW-TP', 'name' => 'world_county.name.2', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '新北市', 'code' => 'TW-NT', 'name' => 'world_county.name.3', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '桃園市', 'code' => 'TW-TY', 'name' => 'world_county.name.4', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '新竹市', 'code' => 'TW-XZ', 'name' => 'world_county.name.5', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '新竹縣', 'code' => 'TW-XZC', 'name' => 'world_county.name.6', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '苗栗縣', 'code' => 'TW-MLC', 'name' => 'world_county.name.7', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '臺中市', 'code' => 'TW-TC', 'name' => 'world_county.name.8', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '彰化縣', 'code' => 'TW-CHC', 'name' => 'world_county.name.9', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '南投縣', 'code' => 'TW-NTC', 'name' => 'world_county.name.10', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '雲林縣', 'code' => 'TW-YLC', 'name' => 'world_county.name.11', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '嘉義市', 'code' => 'TW-CY', 'name' => 'world_county.name.12', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '嘉義縣', 'code' => 'TW-CYC', 'name' => 'world_county.name.13', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '臺南市', 'code' => 'TW-TN', 'name' => 'world_county.name.14', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '高雄市', 'code' => 'TW-KS', 'name' => 'world_county.name.15', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '屏東縣', 'code' => 'TW-PTC', 'name' => 'world_county.name.16', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '臺東縣', 'code' => 'TW-TTC', 'name' => 'world_county.name.17', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '花蓮縣', 'code' => 'TW-HLC', 'name' => 'world_county.name.18', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '宜蘭縣', 'code' => 'TW-YLC', 'name' => 'world_county.name.19', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 5, 'title' => '澎湖縣', 'code' => 'TW-PHC', 'name' => 'world_county.name.20', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 5, 'title' => '金門縣', 'code' => 'TW-KMC', 'name' => 'world_county.name.21', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 5, 'title' => '連江縣', 'code' => 'TW-LJC', 'name' => 'world_county.name.22', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            // ['state_id' => 5, 'title' => '南海島', 'code' => 'TW-HNI', 'name' => '南海島', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            // ['state_id' => 5, 'title' => '釣魚臺', 'code' => 'TW-DYS', 'name' => '釣魚臺', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];

        DB::table('world_county')->insert($worldCountyData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_county', [
            ['name' => '基隆市'], ['name' => '臺北市'], ['name' => '新北市'], ['name' => '桃園市'], ['name' => '新竹市'], ['name' => '新竹縣'],
            ['name' => '苗栗縣'], ['name' => '臺中市'], ['name' => '彰化縣'], ['name' => '南投縣'], ['name' => '雲林縣'], ['name' => '嘉義市'],
            ['name' => '嘉義縣'], ['name' => '臺南市'], ['name' => '高雄市'], ['name' => '屏東縣'], ['name' => '臺東縣'], ['name' => '花蓮縣'],
            ['name' => '宜蘭縣'], ['name' => '澎湖縣'], ['name' => '金門縣'], ['name' => '連江縣']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_county', [
            ['name' => '基隆市'], ['name' => '台北市'], ['name' => '新北市'], ['name' => '桃园市'], [' name' => '新竹市'], ['name' => '新竹县'],
            ['name' => '苗栗县'], ['name' => '台中市'], ['name' => '彰化县'], ['name' => '南投县'], [' name' => '云林县'], ['name' => '嘉义市'],
            ['name' => '嘉义县'], ['name' => '台南市'], ['name' => '高雄市'], ['name' => '屏东县'], [ 'name' => '台东县'], ['name' => '花莲县'],
            ['name' => '宜兰县'], ['name' => '澎湖县'], ['name' => '金门县'], ['name' => '连江县']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_county', [
            ['name' => '基隆市'], ['name' => '台北市'], ['name' => '新北市'], ['name' => '桃園市'], ['name' => '新竹市'], ['name' => '新竹県'],
            ['name' => '苗栗県'], ['name' => '台中市'], ['name' => '彰化県'], ['name' => '南投県'], ['name' => '雲林県'], ['name' => '嘉義市'],
            ['name' => '嘉義県'], ['name' => '台南市'], ['name' => '高雄市'], ['name' => '屏東県'], ['name' => '臺東県'], ['name' => '花蓮県'],
            ['name' => '宜蘭県'], ['name' => '澎湖県'], ['name' => '金門県'], ['name' => '連江県']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_county', [
            ['name' => 'Keelung City'], ['name' => 'Taipei City'], ['name' => 'Xinbei City'], ['name' => 'Taoyuan City'], [' Name' => 'Hsinchu City'], ['name' => 'Hsinchu County'],
            ['name' => 'Miaoli County'], ['name' => 'Taichung City'], ['name' => 'Changhua County'], ['name' => 'Nantou County'], [' Name' => 'Yunlin County'], ['name' => 'Chiayi City'],
            ['name' => 'Chiayi County'], ['name' => 'Tainan City'], ['name' => 'Kaohsiung City'], ['name' => 'Pingdong County'], [ 'name' => 'Taitong County'], ['name' => 'Hualien County'],
            ['name' => 'Yilan County'], ['name' => 'Wuhu County'], ['name' => 'Jinmen County'], ['name' => 'Lianjiang County']
        ], 4));

        // 全球化 - 貨幣
        $worldCurrencyData = [
            ['title' => '新臺幣', 'code' => 'TWD', 'name' => 'world_currency.name.1', 'options' => json_encode(['symbol' => 'NT$', 'native' => 'NTD', 'exchange' => 1.00]), 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '人民幣', 'code' => 'CNY', 'name' => 'world_currency.name.2', 'options' => json_encode(['symbol' => '¥', 'native' => 'RMB', 'exchange' => 0.223905399]), 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '美元', 'code' => 'USD', 'name' => 'world_currency.name.3', 'options' => json_encode(['symbol' => '$', 'native' => 'USD', 'exchange' => 0.032473]), 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        DB::table('world_currency')->insert($worldCurrencyData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_currency', [
            ['name' => '新臺幣'], ['name' => '人民幣'], ['name' => '美元']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_currency', [
            ['name' => '新台币'], ['name' => '人民币'], ['name' => '美元']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_currency', [
            ['name' => '台湾元'], ['name' => '人民元'], ['name' => '米ドル']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_currency', [
            ['name' => 'New Taiwan dollar'], ['name' => 'Renminbi'], ['name' => 'US dollar']
        ], 4));

        DB::table('language_resource')->insert($languageResourceData);
    }
}
