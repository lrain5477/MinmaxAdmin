<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateIoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // IoConstruct 資料匯入匯出結構
        Schema::create('io_construct', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('資料處理名稱');
            $table->string('uri')->comment('Uri');
            $table->boolean('import_enable')->default(true)->comment('匯入啟用');
            $table->boolean('export_enable')->default(true)->comment('匯出啟用');
            $table->string('controller')->comment('Controller');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
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
        Schema::dropIfExists('io_construct');
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
            ['country_id' => 1, 'title' => '北部', 'code' => 'TW-North', 'name' => 'world_state.name.1', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['country_id' => 1, 'title' => '中部', 'code' => 'TW-West', 'name' => 'world_state.name.2', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['country_id' => 1, 'title' => '南部', 'code' => 'TW-South', 'name' => 'world_state.name.3', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['country_id' => 1, 'title' => '東部', 'code' => 'TW-East', 'name' => 'world_state.name.4', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['country_id' => 1, 'title' => '外島', 'code' => 'TW-Island', 'name' => 'world_state.name.5', 'created_at' => $timestamp, 'updated_at' => $timestamp],
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

        // 全球化 - 縣市
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

        // 全球化 - 城市
        $worldCityData = [
            ['county_id' => 1, 'title' => '仁愛區', 'code' => '200', 'name' => 'world_city.name.1', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 1, 'title' => '信義區', 'code' => '201', 'name' => 'world_city.name.2', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 1, 'title' => '中正區', 'code' => '202', 'name' => 'world_city.name.3', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 1, 'title' => '中山區', 'code' => '203', 'name' => 'world_city.name.4', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 1, 'title' => '安樂區', 'code' => '204', 'name' => 'world_city.name.5', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 1, 'title' => '暖暖區', 'code' => '205', 'name' => 'world_city.name.6', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 1, 'title' => '七堵區', 'code' => '206', 'name' => 'world_city.name.7', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '中正區', 'code' => '100', 'name' => 'world_city.name.8', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '大同區', 'code' => '103', 'name' => 'world_city.name.9', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '中山區', 'code' => '104', 'name' => 'world_city.name.10', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '松山區', 'code' => '105', 'name' => 'world_city.name.11', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '大安區', 'code' => '106', 'name' => 'world_city.name.12', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '萬華區', 'code' => '108', 'name' => 'world_city.name.13', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '信義區', 'code' => '110', 'name' => 'world_city.name.14', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '士林區', 'code' => '111', 'name' => 'world_city.name.15', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '北投區', 'code' => '112', 'name' => 'world_city.name.16', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '內湖區', 'code' => '114', 'name' => 'world_city.name.17', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '南港區', 'code' => '115', 'name' => 'world_city.name.18', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 2, 'title' => '文山區', 'code' => '116', 'name' => 'world_city.name.19', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '萬里區', 'code' => '207', 'name' => 'world_city.name.20', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '金山區', 'code' => '208', 'name' => 'world_city.name.21', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '板橋區', 'code' => '220', 'name' => 'world_city.name.22', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '汐止區', 'code' => '221', 'name' => 'world_city.name.23', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '深坑區', 'code' => '222', 'name' => 'world_city.name.24', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '石碇區', 'code' => '223', 'name' => 'world_city.name.25', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '瑞芳區', 'code' => '224', 'name' => 'world_city.name.26', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '平溪區', 'code' => '226', 'name' => 'world_city.name.27', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '雙溪區', 'code' => '227', 'name' => 'world_city.name.28', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '貢寮區', 'code' => '228', 'name' => 'world_city.name.29', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '新店區', 'code' => '231', 'name' => 'world_city.name.30', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '坪林區', 'code' => '232', 'name' => 'world_city.name.31', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '烏來區', 'code' => '233', 'name' => 'world_city.name.32', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '永和區', 'code' => '234', 'name' => 'world_city.name.33', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '中和區', 'code' => '235', 'name' => 'world_city.name.34', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '土城區', 'code' => '236', 'name' => 'world_city.name.35', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '三峽區', 'code' => '237', 'name' => 'world_city.name.36', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '樹林區', 'code' => '238', 'name' => 'world_city.name.37', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '鶯歌區', 'code' => '239', 'name' => 'world_city.name.38', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '三重區', 'code' => '241', 'name' => 'world_city.name.39', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '新莊區', 'code' => '242', 'name' => 'world_city.name.40', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '泰山區', 'code' => '243', 'name' => 'world_city.name.41', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '林口區', 'code' => '244', 'name' => 'world_city.name.42', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '蘆洲區', 'code' => '247', 'name' => 'world_city.name.43', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '五股區', 'code' => '248', 'name' => 'world_city.name.44', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '八里區', 'code' => '249', 'name' => 'world_city.name.45', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '淡水區', 'code' => '251', 'name' => 'world_city.name.46', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '三芝區', 'code' => '252', 'name' => 'world_city.name.47', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 3, 'title' => '石門區', 'code' => '253', 'name' => 'world_city.name.48', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '中壢區', 'code' => '320', 'name' => 'world_city.name.49', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '平鎮區', 'code' => '324', 'name' => 'world_city.name.50', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '龍潭區', 'code' => '325', 'name' => 'world_city.name.51', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '楊梅區', 'code' => '326', 'name' => 'world_city.name.52', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '新屋區', 'code' => '327', 'name' => 'world_city.name.53', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '觀音區', 'code' => '328', 'name' => 'world_city.name.54', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '桃園區', 'code' => '330', 'name' => 'world_city.name.55', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '龜山區', 'code' => '333', 'name' => 'world_city.name.56', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '八德區', 'code' => '334', 'name' => 'world_city.name.57', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '大溪區', 'code' => '335', 'name' => 'world_city.name.58', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '復興區', 'code' => '336', 'name' => 'world_city.name.59', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '大園區', 'code' => '337', 'name' => 'world_city.name.60', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 4, 'title' => '蘆竹區', 'code' => '338', 'name' => 'world_city.name.61', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 5, 'title' => '東區', 'code' => '300', 'name' => 'world_city.name.62', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 5, 'title' => '北區', 'code' => '300', 'name' => 'world_city.name.63', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 5, 'title' => '香山區', 'code' => '300', 'name' => 'world_city.name.64', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '竹北市', 'code' => '302', 'name' => 'world_city.name.65', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '湖口鄉', 'code' => '303', 'name' => 'world_city.name.66', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '新豐鄉', 'code' => '304', 'name' => 'world_city.name.67', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '新埔鎮', 'code' => '305', 'name' => 'world_city.name.68', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '關西鎮', 'code' => '306', 'name' => 'world_city.name.69', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '芎林鄉', 'code' => '307', 'name' => 'world_city.name.70', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '寶山鄉', 'code' => '308', 'name' => 'world_city.name.71', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '竹東鎮', 'code' => '310', 'name' => 'world_city.name.72', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '五峰鄉', 'code' => '311', 'name' => 'world_city.name.73', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '橫山鄉', 'code' => '312', 'name' => 'world_city.name.74', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '尖石鄉', 'code' => '313', 'name' => 'world_city.name.75', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '北埔鄉', 'code' => '314', 'name' => 'world_city.name.76', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 6, 'title' => '峨眉鄉', 'code' => '315', 'name' => 'world_city.name.77', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '竹南鎮', 'code' => '350', 'name' => 'world_city.name.78', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '頭份市', 'code' => '351', 'name' => 'world_city.name.79', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '三灣鄉', 'code' => '352', 'name' => 'world_city.name.80', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '南庄鄉', 'code' => '353', 'name' => 'world_city.name.81', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '獅潭鄉', 'code' => '354', 'name' => 'world_city.name.82', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '後龍鎮', 'code' => '356', 'name' => 'world_city.name.83', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '通霄鎮', 'code' => '357', 'name' => 'world_city.name.84', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '苑裡鎮', 'code' => '358', 'name' => 'world_city.name.85', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '苗栗市', 'code' => '360', 'name' => 'world_city.name.86', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '造橋鄉', 'code' => '361', 'name' => 'world_city.name.87', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '頭屋鄉', 'code' => '362', 'name' => 'world_city.name.88', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '公館鄉', 'code' => '363', 'name' => 'world_city.name.89', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '大湖鄉', 'code' => '364', 'name' => 'world_city.name.90', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '泰安鄉', 'code' => '365', 'name' => 'world_city.name.91', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '銅鑼鄉', 'code' => '366', 'name' => 'world_city.name.92', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '三義鄉', 'code' => '367', 'name' => 'world_city.name.93', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '西湖鄉', 'code' => '368', 'name' => 'world_city.name.94', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 7, 'title' => '卓蘭鎮', 'code' => '369', 'name' => 'world_city.name.95', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '中區', 'code' => '400', 'name' => 'world_city.name.96', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '東區', 'code' => '401', 'name' => 'world_city.name.97', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '南區', 'code' => '402', 'name' => 'world_city.name.98', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '西區', 'code' => '403', 'name' => 'world_city.name.99', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '北區', 'code' => '404', 'name' => 'world_city.name.100', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '北屯區', 'code' => '406', 'name' => 'world_city.name.101', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '西屯區', 'code' => '407', 'name' => 'world_city.name.102', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '南屯區', 'code' => '408', 'name' => 'world_city.name.103', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '太平區', 'code' => '411', 'name' => 'world_city.name.104', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '大里區', 'code' => '412', 'name' => 'world_city.name.105', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '霧峰區', 'code' => '413', 'name' => 'world_city.name.106', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '烏日區', 'code' => '414', 'name' => 'world_city.name.107', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '豐原區', 'code' => '420', 'name' => 'world_city.name.108', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '后里區', 'code' => '421', 'name' => 'world_city.name.109', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '石岡區', 'code' => '422', 'name' => 'world_city.name.110', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '東勢區', 'code' => '423', 'name' => 'world_city.name.111', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '和平區', 'code' => '424', 'name' => 'world_city.name.112', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '新社區', 'code' => '426', 'name' => 'world_city.name.113', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '潭子區', 'code' => '427', 'name' => 'world_city.name.114', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '大雅區', 'code' => '428', 'name' => 'world_city.name.115', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '神岡區', 'code' => '429', 'name' => 'world_city.name.116', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '大肚區', 'code' => '432', 'name' => 'world_city.name.117', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '沙鹿區', 'code' => '433', 'name' => 'world_city.name.118', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '龍井區', 'code' => '434', 'name' => 'world_city.name.119', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '梧棲區', 'code' => '435', 'name' => 'world_city.name.120', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '清水區', 'code' => '436', 'name' => 'world_city.name.121', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '大甲區', 'code' => '437', 'name' => 'world_city.name.122', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '外埔區', 'code' => '438', 'name' => 'world_city.name.123', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 8, 'title' => '大安區', 'code' => '439', 'name' => 'world_city.name.124', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '彰化市', 'code' => '500', 'name' => 'world_city.name.125', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '芬園鄉', 'code' => '502', 'name' => 'world_city.name.126', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '花壇鄉', 'code' => '503', 'name' => 'world_city.name.127', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '秀水鄉', 'code' => '504', 'name' => 'world_city.name.128', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '鹿港鎮', 'code' => '505', 'name' => 'world_city.name.129', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '福興鄉', 'code' => '506', 'name' => 'world_city.name.130', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '線西鄉', 'code' => '507', 'name' => 'world_city.name.131', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '和美鎮', 'code' => '508', 'name' => 'world_city.name.132', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '伸港鄉', 'code' => '509', 'name' => 'world_city.name.133', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '員林市', 'code' => '510', 'name' => 'world_city.name.134', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '社頭鄉', 'code' => '511', 'name' => 'world_city.name.135', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '永靖鄉', 'code' => '512', 'name' => 'world_city.name.136', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '埔心鄉', 'code' => '513', 'name' => 'world_city.name.137', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '溪湖鎮', 'code' => '514', 'name' => 'world_city.name.138', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '大村鄉', 'code' => '515', 'name' => 'world_city.name.139', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '埔鹽鄉', 'code' => '516', 'name' => 'world_city.name.140', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '田中鎮', 'code' => '520', 'name' => 'world_city.name.141', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '北斗鎮', 'code' => '521', 'name' => 'world_city.name.142', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '田尾鄉', 'code' => '522', 'name' => 'world_city.name.143', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '埤頭鄉', 'code' => '523', 'name' => 'world_city.name.144', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '溪州鄉', 'code' => '524', 'name' => 'world_city.name.145', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '竹塘鄉', 'code' => '525', 'name' => 'world_city.name.146', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '二林鎮', 'code' => '526', 'name' => 'world_city.name.147', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '大城鄉', 'code' => '527', 'name' => 'world_city.name.148', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '芳苑鄉', 'code' => '528', 'name' => 'world_city.name.149', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 9, 'title' => '二水鄉', 'code' => '530', 'name' => 'world_city.name.150', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '南投市', 'code' => '540', 'name' => 'world_city.name.151', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '中寮鄉', 'code' => '541', 'name' => 'world_city.name.152', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '草屯鎮', 'code' => '542', 'name' => 'world_city.name.153', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '國姓鄉', 'code' => '544', 'name' => 'world_city.name.154', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '埔里鎮', 'code' => '545', 'name' => 'world_city.name.155', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '仁愛鄉', 'code' => '546', 'name' => 'world_city.name.156', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '名間鄉', 'code' => '551', 'name' => 'world_city.name.157', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '集集鎮', 'code' => '552', 'name' => 'world_city.name.158', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '水里鄉', 'code' => '553', 'name' => 'world_city.name.159', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '魚池鄉', 'code' => '555', 'name' => 'world_city.name.160', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '信義鄉', 'code' => '556', 'name' => 'world_city.name.161', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '竹山鎮', 'code' => '557', 'name' => 'world_city.name.162', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 10, 'title' => '鹿谷鄉', 'code' => '558', 'name' => 'world_city.name.163', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '斗南鎮', 'code' => '630', 'name' => 'world_city.name.164', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '大埤鄉', 'code' => '631', 'name' => 'world_city.name.165', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '虎尾鎮', 'code' => '632', 'name' => 'world_city.name.166', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '土庫鎮', 'code' => '633', 'name' => 'world_city.name.167', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '褒忠鄉', 'code' => '634', 'name' => 'world_city.name.168', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '東勢鄉', 'code' => '635', 'name' => 'world_city.name.169', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '臺西鄉', 'code' => '636', 'name' => 'world_city.name.170', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '崙背鄉', 'code' => '637', 'name' => 'world_city.name.171', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '麥寮鄉', 'code' => '638', 'name' => 'world_city.name.172', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '斗六市', 'code' => '640', 'name' => 'world_city.name.173', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '林內鄉', 'code' => '643', 'name' => 'world_city.name.174', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '古坑鄉', 'code' => '646', 'name' => 'world_city.name.175', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '莿桐鄉', 'code' => '647', 'name' => 'world_city.name.176', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '西螺鎮', 'code' => '648', 'name' => 'world_city.name.177', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '二崙鄉', 'code' => '649', 'name' => 'world_city.name.178', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '北港鎮', 'code' => '651', 'name' => 'world_city.name.179', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '水林鄉', 'code' => '652', 'name' => 'world_city.name.180', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '口湖鄉', 'code' => '653', 'name' => 'world_city.name.181', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '四湖鄉', 'code' => '654', 'name' => 'world_city.name.182', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 11, 'title' => '元長鄉', 'code' => '655', 'name' => 'world_city.name.183', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 12, 'title' => '東區', 'code' => '600', 'name' => 'world_city.name.184', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 12, 'title' => '西區', 'code' => '600', 'name' => 'world_city.name.185', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '番路鄉', 'code' => '602', 'name' => 'world_city.name.186', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '梅山鄉', 'code' => '603', 'name' => 'world_city.name.187', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '竹崎鄉', 'code' => '604', 'name' => 'world_city.name.188', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '阿里山鄉', 'code' => '605', 'name' => 'world_city.name.189', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '中埔鄉', 'code' => '606', 'name' => 'world_city.name.190', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '大埔鄉', 'code' => '607', 'name' => 'world_city.name.191', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '水上鄉', 'code' => '608', 'name' => 'world_city.name.192', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '鹿草鄉', 'code' => '611', 'name' => 'world_city.name.193', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '太保市', 'code' => '612', 'name' => 'world_city.name.194', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '朴子市', 'code' => '613', 'name' => 'world_city.name.195', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '東石鄉', 'code' => '614', 'name' => 'world_city.name.196', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '六腳鄉', 'code' => '615', 'name' => 'world_city.name.197', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '新港鄉', 'code' => '616', 'name' => 'world_city.name.198', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '民雄鄉', 'code' => '621', 'name' => 'world_city.name.199', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '大林鎮', 'code' => '622', 'name' => 'world_city.name.200', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '溪口鄉', 'code' => '623', 'name' => 'world_city.name.201', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '義竹鄉', 'code' => '624', 'name' => 'world_city.name.202', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 13, 'title' => '布袋鎮', 'code' => '625', 'name' => 'world_city.name.203', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '中西區', 'code' => '700', 'name' => 'world_city.name.204', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '東區', 'code' => '701', 'name' => 'world_city.name.205', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '南區', 'code' => '702', 'name' => 'world_city.name.206', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '北區', 'code' => '704', 'name' => 'world_city.name.207', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '安平區', 'code' => '708', 'name' => 'world_city.name.208', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '安南區', 'code' => '709', 'name' => 'world_city.name.209', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '永康區', 'code' => '710', 'name' => 'world_city.name.210', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '歸仁區', 'code' => '711', 'name' => 'world_city.name.211', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '新化區', 'code' => '712', 'name' => 'world_city.name.212', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '左鎮區', 'code' => '713', 'name' => 'world_city.name.213', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '玉井區', 'code' => '714', 'name' => 'world_city.name.214', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '楠西區', 'code' => '715', 'name' => 'world_city.name.215', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '南化區', 'code' => '716', 'name' => 'world_city.name.216', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '仁德區', 'code' => '717', 'name' => 'world_city.name.217', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '關廟區', 'code' => '718', 'name' => 'world_city.name.218', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '龍崎區', 'code' => '719', 'name' => 'world_city.name.219', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '官田區', 'code' => '720', 'name' => 'world_city.name.220', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '麻豆區', 'code' => '721', 'name' => 'world_city.name.221', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '佳里區', 'code' => '722', 'name' => 'world_city.name.222', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '西港區', 'code' => '723', 'name' => 'world_city.name.223', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '七股區', 'code' => '724', 'name' => 'world_city.name.224', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '將軍區', 'code' => '725', 'name' => 'world_city.name.225', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '學甲區', 'code' => '726', 'name' => 'world_city.name.226', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '北門區', 'code' => '727', 'name' => 'world_city.name.227', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '新營區', 'code' => '730', 'name' => 'world_city.name.228', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '後壁區', 'code' => '731', 'name' => 'world_city.name.229', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '白河區', 'code' => '732', 'name' => 'world_city.name.230', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '東山區', 'code' => '733', 'name' => 'world_city.name.231', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '六甲區', 'code' => '734', 'name' => 'world_city.name.232', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '下營區', 'code' => '735', 'name' => 'world_city.name.233', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '柳營區', 'code' => '736', 'name' => 'world_city.name.234', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '鹽水區', 'code' => '737', 'name' => 'world_city.name.235', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '善化區', 'code' => '741', 'name' => 'world_city.name.236', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '大內區', 'code' => '742', 'name' => 'world_city.name.237', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '山上區', 'code' => '743', 'name' => 'world_city.name.238', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '新市區', 'code' => '744', 'name' => 'world_city.name.239', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 14, 'title' => '安定區', 'code' => '745', 'name' => 'world_city.name.240', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '新興區', 'code' => '800', 'name' => 'world_city.name.241', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '前金區', 'code' => '801', 'name' => 'world_city.name.242', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '苓雅區', 'code' => '802', 'name' => 'world_city.name.243', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '鹽埕區', 'code' => '803', 'name' => 'world_city.name.244', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '鼓山區', 'code' => '804', 'name' => 'world_city.name.245', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '旗津區', 'code' => '805', 'name' => 'world_city.name.246', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '前鎮區', 'code' => '806', 'name' => 'world_city.name.247', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '三民區', 'code' => '807', 'name' => 'world_city.name.248', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '楠梓區', 'code' => '811', 'name' => 'world_city.name.249', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '小港區', 'code' => '812', 'name' => 'world_city.name.250', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '左營區', 'code' => '813', 'name' => 'world_city.name.251', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '仁武區', 'code' => '814', 'name' => 'world_city.name.252', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '大社區', 'code' => '815', 'name' => 'world_city.name.253', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '東沙群島', 'code' => '817', 'name' => 'world_city.name.254', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '南沙群島', 'code' => '819', 'name' => 'world_city.name.255', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '岡山區', 'code' => '820', 'name' => 'world_city.name.256', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '路竹區', 'code' => '821', 'name' => 'world_city.name.257', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '阿蓮區', 'code' => '822', 'name' => 'world_city.name.258', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '田寮區', 'code' => '823', 'name' => 'world_city.name.259', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '燕巢區', 'code' => '824', 'name' => 'world_city.name.260', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '橋頭區', 'code' => '825', 'name' => 'world_city.name.261', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '梓官區', 'code' => '826', 'name' => 'world_city.name.262', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '彌陀區', 'code' => '827', 'name' => 'world_city.name.263', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '永安區', 'code' => '828', 'name' => 'world_city.name.264', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '湖內區', 'code' => '829', 'name' => 'world_city.name.265', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '鳳山區', 'code' => '830', 'name' => 'world_city.name.266', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '大寮區', 'code' => '831', 'name' => 'world_city.name.267', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '林園區', 'code' => '832', 'name' => 'world_city.name.268', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '鳥松區', 'code' => '833', 'name' => 'world_city.name.269', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '大樹區', 'code' => '840', 'name' => 'world_city.name.270', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '旗山區', 'code' => '842', 'name' => 'world_city.name.271', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '美濃區', 'code' => '843', 'name' => 'world_city.name.272', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '六龜區', 'code' => '844', 'name' => 'world_city.name.273', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '內門區', 'code' => '845', 'name' => 'world_city.name.274', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '杉林區', 'code' => '846', 'name' => 'world_city.name.275', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '甲仙區', 'code' => '847', 'name' => 'world_city.name.276', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '桃源區', 'code' => '848', 'name' => 'world_city.name.277', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '那瑪夏區', 'code' => '849', 'name' => 'world_city.name.278', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '茂林區', 'code' => '851', 'name' => 'world_city.name.279', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 15, 'title' => '茄萣區', 'code' => '852', 'name' => 'world_city.name.280', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '屏東市', 'code' => '900', 'name' => 'world_city.name.281', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '三地門鄉', 'code' => '901', 'name' => 'world_city.name.282', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '霧臺鄉', 'code' => '902', 'name' => 'world_city.name.283', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '瑪家鄉', 'code' => '903', 'name' => 'world_city.name.284', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '九如鄉', 'code' => '904', 'name' => 'world_city.name.285', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '里港鄉', 'code' => '905', 'name' => 'world_city.name.286', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '高樹鄉', 'code' => '906', 'name' => 'world_city.name.287', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '鹽埔鄉', 'code' => '907', 'name' => 'world_city.name.288', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '長治鄉', 'code' => '908', 'name' => 'world_city.name.289', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '麟洛鄉', 'code' => '909', 'name' => 'world_city.name.290', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '竹田鄉', 'code' => '911', 'name' => 'world_city.name.291', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '內埔鄉', 'code' => '912', 'name' => 'world_city.name.292', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '萬丹鄉', 'code' => '913', 'name' => 'world_city.name.293', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '潮州鎮', 'code' => '920', 'name' => 'world_city.name.294', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '泰武鄉', 'code' => '921', 'name' => 'world_city.name.295', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '來義鄉', 'code' => '922', 'name' => 'world_city.name.296', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '萬巒鄉', 'code' => '923', 'name' => 'world_city.name.297', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '崁頂鄉', 'code' => '924', 'name' => 'world_city.name.298', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '新埤鄉', 'code' => '925', 'name' => 'world_city.name.299', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '南州鄉', 'code' => '926', 'name' => 'world_city.name.300', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '林邊鄉', 'code' => '927', 'name' => 'world_city.name.301', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '東港鎮', 'code' => '928', 'name' => 'world_city.name.302', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '琉球鄉', 'code' => '929', 'name' => 'world_city.name.303', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '佳冬鄉', 'code' => '931', 'name' => 'world_city.name.304', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '新園鄉', 'code' => '932', 'name' => 'world_city.name.305', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '枋寮鄉', 'code' => '940', 'name' => 'world_city.name.306', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '枋山鄉', 'code' => '941', 'name' => 'world_city.name.307', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '春日鄉', 'code' => '942', 'name' => 'world_city.name.308', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '獅子鄉', 'code' => '943', 'name' => 'world_city.name.309', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '車城鄉', 'code' => '944', 'name' => 'world_city.name.310', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '牡丹鄉', 'code' => '945', 'name' => 'world_city.name.311', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '恆春鎮', 'code' => '946', 'name' => 'world_city.name.312', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 16, 'title' => '滿州鄉', 'code' => '947', 'name' => 'world_city.name.313', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '臺東市', 'code' => '950', 'name' => 'world_city.name.314', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '綠島鄉', 'code' => '951', 'name' => 'world_city.name.315', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '蘭嶼鄉', 'code' => '952', 'name' => 'world_city.name.316', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '延平鄉', 'code' => '953', 'name' => 'world_city.name.317', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '卑南鄉', 'code' => '954', 'name' => 'world_city.name.318', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '鹿野鄉', 'code' => '955', 'name' => 'world_city.name.319', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '關山鎮', 'code' => '956', 'name' => 'world_city.name.320', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '海端鄉', 'code' => '957', 'name' => 'world_city.name.321', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '池上鄉', 'code' => '958', 'name' => 'world_city.name.322', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '東河鄉', 'code' => '959', 'name' => 'world_city.name.323', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '成功鎮', 'code' => '961', 'name' => 'world_city.name.324', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '長濱鄉', 'code' => '962', 'name' => 'world_city.name.325', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '太麻里鄉', 'code' => '963', 'name' => 'world_city.name.326', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '金峰鄉', 'code' => '964', 'name' => 'world_city.name.327', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '大武鄉', 'code' => '965', 'name' => 'world_city.name.328', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 17, 'title' => '達仁鄉', 'code' => '966', 'name' => 'world_city.name.329', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '花蓮市', 'code' => '970', 'name' => 'world_city.name.330', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '新城鄉', 'code' => '971', 'name' => 'world_city.name.331', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '秀林鄉', 'code' => '972', 'name' => 'world_city.name.332', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '吉安鄉', 'code' => '973', 'name' => 'world_city.name.333', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '壽豐鄉', 'code' => '974', 'name' => 'world_city.name.334', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '鳳林鎮', 'code' => '975', 'name' => 'world_city.name.335', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '光復鄉', 'code' => '976', 'name' => 'world_city.name.336', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '豐濱鄉', 'code' => '977', 'name' => 'world_city.name.337', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '瑞穗鄉', 'code' => '978', 'name' => 'world_city.name.338', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '萬榮鄉', 'code' => '979', 'name' => 'world_city.name.339', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '玉里鎮', 'code' => '981', 'name' => 'world_city.name.340', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '卓溪鄉', 'code' => '982', 'name' => 'world_city.name.341', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 18, 'title' => '富里鄉', 'code' => '983', 'name' => 'world_city.name.342', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '宜蘭市', 'code' => '260', 'name' => 'world_city.name.343', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '頭城鎮', 'code' => '261', 'name' => 'world_city.name.344', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '礁溪鄉', 'code' => '262', 'name' => 'world_city.name.345', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '壯圍鄉', 'code' => '263', 'name' => 'world_city.name.346', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '員山鄉', 'code' => '264', 'name' => 'world_city.name.347', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '羅東鎮', 'code' => '265', 'name' => 'world_city.name.348', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '三星鄉', 'code' => '266', 'name' => 'world_city.name.349', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '大同鄉', 'code' => '267', 'name' => 'world_city.name.350', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '五結鄉', 'code' => '268', 'name' => 'world_city.name.351', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '冬山鄉', 'code' => '269', 'name' => 'world_city.name.352', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '蘇澳鎮', 'code' => '270', 'name' => 'world_city.name.353', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '南澳鄉', 'code' => '272', 'name' => 'world_city.name.354', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 19, 'title' => '釣魚臺', 'code' => '290', 'name' => 'world_city.name.355', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 20, 'title' => '馬公市', 'code' => '880', 'name' => 'world_city.name.356', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 20, 'title' => '西嶼鄉', 'code' => '881', 'name' => 'world_city.name.357', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 20, 'title' => '望安鄉', 'code' => '882', 'name' => 'world_city.name.358', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 20, 'title' => '七美鄉', 'code' => '883', 'name' => 'world_city.name.359', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 20, 'title' => '白沙鄉', 'code' => '884', 'name' => 'world_city.name.360', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 20, 'title' => '湖西鄉', 'code' => '885', 'name' => 'world_city.name.361', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 21, 'title' => '金沙鎮', 'code' => '890', 'name' => 'world_city.name.362', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 21, 'title' => '金湖鎮', 'code' => '891', 'name' => 'world_city.name.363', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 21, 'title' => '金寧鄉', 'code' => '892', 'name' => 'world_city.name.364', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 21, 'title' => '金城鎮', 'code' => '893', 'name' => 'world_city.name.365', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 21, 'title' => '烈嶼鄉', 'code' => '894', 'name' => 'world_city.name.366', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 21, 'title' => '烏坵鄉', 'code' => '896', 'name' => 'world_city.name.367', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 22, 'title' => '南竿鄉', 'code' => '209', 'name' => 'world_city.name.368', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 22, 'title' => '北竿鄉', 'code' => '210', 'name' => 'world_city.name.369', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 22, 'title' => '莒光鄉', 'code' => '211', 'name' => 'world_city.name.370', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['county_id' => 22, 'title' => '東引鄉', 'code' => '212', 'name' => 'world_city.name.371', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        DB::table('world_city')->insert($worldCityData);

        $tempCityLanguageData = [];
        foreach ($worldCityData as $cityData)  $tempCityLanguageData[] = ['name' => $cityData['title']];

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_city', $tempCityLanguageData, 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_city', $tempCityLanguageData, 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_city', $tempCityLanguageData, 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_city', $tempCityLanguageData, 4));

        // 全球化 - 貨幣
        $worldCurrencyData = [
            ['title' => '新臺幣', 'code' => 'TWD', 'name' => 'world_currency.name.1', 'options' => json_encode(['symbol' => 'NT$', 'native' => 'NTD', 'exchange' => 1.00]), 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '人民幣', 'code' => 'CNY', 'name' => 'world_currency.name.2', 'options' => json_encode(['symbol' => '¥', 'native' => 'RMB', 'exchange' => 0.223905399]), 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '日圓', 'code' => 'JPY', 'name' => 'world_currency.name.3', 'options' => json_encode(['symbol' => '¥', 'native' => 'JPY', 'exchange' => 3.65070264]), 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['title' => '美元', 'code' => 'USD', 'name' => 'world_currency.name.4', 'options' => json_encode(['symbol' => '$', 'native' => 'USD', 'exchange' => 0.032473]), 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        DB::table('world_currency')->insert($worldCurrencyData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_currency', [
            ['name' => '新臺幣'], ['name' => '人民幣'], ['name' => '日圓'], ['name' => '美元']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_currency', [
            ['name' => '新台币'], ['name' => '人民币'], ['name' => '日圆'], ['name' => '美元']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_currency', [
            ['name' => '台湾元'], ['name' => '人民元'], ['name' => '日本円'], ['name' => '米ドル']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('world_currency', [
            ['name' => 'New Taiwan dollar'], ['name' => 'Renminbi'], ['name' => 'Japanese yen'], ['name' => 'US dollar']
        ], 4));

        DB::table('language_resource')->insert($languageResourceData);
    }
}
