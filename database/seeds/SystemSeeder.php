<?php

use App\Helpers\SeederHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Throwable
     */
    public function run()
    {
        $defaultLanguage = config('app.local');
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $worldLanguageData = [
            ['title' => '繁中', 'code' => 'tw', 'name' => '繁體中文', 'icon' => 'flag-icon-tw', 'sort' => 1, 'active' => '1', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            // ['title' => '簡中', 'code' => 'cn', 'name' => '简体中文', 'icon' => 'flag-icon-cn', 'sort' => 2, 'active' => '0', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            // ['title' => '英文', 'code' => 'en', 'name' => 'English', 'icon' => 'flag-icon-us', 'sort' => 3, 'active' => '0', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        foreach ($worldLanguageData as $key => $item) {
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'world_language.name.' . ($key + 1), 'text' => $item['name'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            $worldLanguageData[$key]['name'] = 'world_language.name.' . ($key + 1);
        }

        DB::table('world_language')->insert($worldLanguageData);

        \Cache::forget('langId');

        $countryData = [
            [
                'title' => '臺灣',
                'code' => 'TW',
                'name' => '臺灣',
                'icon' => 'flag-icon-tw',
                'language_id' => 1,
                'active' => '1',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ];

        foreach ($countryData as $key => $item) {
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'world_country.name.' . ($key + 1), 'text' => $item['name'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            $countryData[$key]['name'] = 'world_country.name.' . ($key + 1);
        }

        DB::table('world_country')->insert($countryData);

        $stateData = [
            ['country_id' => 1, 'title' => '基隆市', 'code' => 'TW-KL', 'name' => '基隆市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '臺北市', 'code' => 'TW-TP', 'name' => '臺北市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '新北市', 'code' => 'TW-NT', 'name' => '新北市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '桃園市', 'code' => 'TW-TY', 'name' => '桃園市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '新竹市', 'code' => 'TW-XZ', 'name' => '新竹市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '新竹縣', 'code' => 'TW-XZC', 'name' => '新竹縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '苗栗縣', 'code' => 'TW-MLC', 'name' => '苗栗縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '臺中市', 'code' => 'TW-TC', 'name' => '臺中市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '彰化縣', 'code' => 'TW-CHC', 'name' => '彰化縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '南投縣', 'code' => 'TW-NTC', 'name' => '南投縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '雲林縣', 'code' => 'TW-YLC', 'name' => '雲林縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '嘉義市', 'code' => 'TW-CY', 'name' => '嘉義市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '嘉義縣', 'code' => 'TW-CYC', 'name' => '嘉義縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '臺南市', 'code' => 'TW-TN', 'name' => '臺南市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '高雄市', 'code' => 'TW-KS', 'name' => '高雄市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '屏東縣', 'code' => 'TW-PTC', 'name' => '屏東縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '臺東縣', 'code' => 'TW-TTC', 'name' => '臺東縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '花蓮縣', 'code' => 'TW-HLC', 'name' => '花蓮縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '宜蘭縣', 'code' => 'TW-YLC', 'name' => '宜蘭縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '澎湖縣', 'code' => 'TW-PHC', 'name' => '澎湖縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '金門縣', 'code' => 'TW-KMC', 'name' => '金門縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '連江縣', 'code' => 'TW-LJC', 'name' => '連江縣', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            // ['country_id' => $countryGuid01, 'title' => '南海島', 'code' => 'TW-HNI', 'name' => '南海島', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            // ['country_id' => $countryGuid01, 'title' => '釣魚臺', 'code' => 'TW-DYS', 'name' => '釣魚臺', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];

        foreach ($stateData as $key => $item) {
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'world_state.name.' . ($key + 1), 'text' => $item['name'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            $stateData[$key]['name'] = 'world_state.name.' . ($key + 1);
        }

        DB::table('world_state')->insert($stateData);

        $cityData = [
            ['state_id' => 1, 'title' => '仁愛區', 'code' => '200', 'name' => '仁愛區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '信義區', 'code' => '201', 'name' => '信義區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '中正區', 'code' => '202', 'name' => '中正區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '中山區', 'code' => '203', 'name' => '中山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '安樂區', 'code' => '204', 'name' => '安樂區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '暖暖區', 'code' => '205', 'name' => '暖暖區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 1, 'title' => '七堵區', 'code' => '206', 'name' => '七堵區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '中正區', 'code' => '100', 'name' => '中正區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '大同區', 'code' => '103', 'name' => '大同區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '中山區', 'code' => '104', 'name' => '中山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '松山區', 'code' => '105', 'name' => '松山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '大安區', 'code' => '106', 'name' => '大安區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '萬華區', 'code' => '108', 'name' => '萬華區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '信義區', 'code' => '110', 'name' => '信義區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '士林區', 'code' => '111', 'name' => '士林區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '北投區', 'code' => '112', 'name' => '北投區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '內湖區', 'code' => '114', 'name' => '內湖區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '南港區', 'code' => '115', 'name' => '南港區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 2, 'title' => '文山區', 'code' => '116', 'name' => '文山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '萬里區', 'code' => '207', 'name' => '萬里區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '金山區', 'code' => '208', 'name' => '金山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '板橋區', 'code' => '220', 'name' => '板橋區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '汐止區', 'code' => '221', 'name' => '汐止區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '深坑區', 'code' => '222', 'name' => '深坑區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '石碇區', 'code' => '223', 'name' => '石碇區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '瑞芳區', 'code' => '224', 'name' => '瑞芳區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '平溪區', 'code' => '226', 'name' => '平溪區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '雙溪區', 'code' => '227', 'name' => '雙溪區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '貢寮區', 'code' => '228', 'name' => '貢寮區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '新店區', 'code' => '231', 'name' => '新店區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '坪林區', 'code' => '232', 'name' => '坪林區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '烏來區', 'code' => '233', 'name' => '烏來區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '永和區', 'code' => '234', 'name' => '永和區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '中和區', 'code' => '235', 'name' => '中和區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '土城區', 'code' => '236', 'name' => '土城區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '三峽區', 'code' => '237', 'name' => '三峽區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '樹林區', 'code' => '238', 'name' => '樹林區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '鶯歌區', 'code' => '239', 'name' => '鶯歌區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '三重區', 'code' => '241', 'name' => '三重區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '新莊區', 'code' => '242', 'name' => '新莊區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '泰山區', 'code' => '243', 'name' => '泰山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '林口區', 'code' => '244', 'name' => '林口區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '蘆洲區', 'code' => '247', 'name' => '蘆洲區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '五股區', 'code' => '248', 'name' => '五股區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '八里區', 'code' => '249', 'name' => '八里區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '淡水區', 'code' => '251', 'name' => '淡水區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '三芝區', 'code' => '252', 'name' => '三芝區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 3, 'title' => '石門區', 'code' => '253', 'name' => '石門區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '中壢區', 'code' => '320', 'name' => '中壢區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '平鎮區', 'code' => '324', 'name' => '平鎮區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '龍潭區', 'code' => '325', 'name' => '龍潭區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '楊梅區', 'code' => '326', 'name' => '楊梅區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '新屋區', 'code' => '327', 'name' => '新屋區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '觀音區', 'code' => '328', 'name' => '觀音區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '桃園區', 'code' => '330', 'name' => '桃園區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '龜山區', 'code' => '333', 'name' => '龜山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '八德區', 'code' => '334', 'name' => '八德區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '大溪區', 'code' => '335', 'name' => '大溪區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '復興區', 'code' => '336', 'name' => '復興區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '大園區', 'code' => '337', 'name' => '大園區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 4, 'title' => '蘆竹區', 'code' => '338', 'name' => '蘆竹區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 5, 'title' => '東區', 'code' => '300', 'name' => '東區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 5, 'title' => '北區', 'code' => '300', 'name' => '北區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 5, 'title' => '香山區', 'code' => '300', 'name' => '香山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '竹北市', 'code' => '302', 'name' => '竹北市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '湖口鄉', 'code' => '303', 'name' => '湖口鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '新豐鄉', 'code' => '304', 'name' => '新豐鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '新埔鎮', 'code' => '305', 'name' => '新埔鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '關西鎮', 'code' => '306', 'name' => '關西鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '芎林鄉', 'code' => '307', 'name' => '芎林鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '寶山鄉', 'code' => '308', 'name' => '寶山鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '竹東鎮', 'code' => '310', 'name' => '竹東鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '五峰鄉', 'code' => '311', 'name' => '五峰鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '橫山鄉', 'code' => '312', 'name' => '橫山鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '尖石鄉', 'code' => '313', 'name' => '尖石鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '北埔鄉', 'code' => '314', 'name' => '北埔鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 6, 'title' => '峨眉鄉', 'code' => '315', 'name' => '峨眉鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '竹南鎮', 'code' => '350', 'name' => '竹南鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '頭份市', 'code' => '351', 'name' => '頭份市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '三灣鄉', 'code' => '352', 'name' => '三灣鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '南庄鄉', 'code' => '353', 'name' => '南庄鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '獅潭鄉', 'code' => '354', 'name' => '獅潭鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '後龍鎮', 'code' => '356', 'name' => '後龍鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '通霄鎮', 'code' => '357', 'name' => '通霄鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '苑裡鎮', 'code' => '358', 'name' => '苑裡鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '苗栗市', 'code' => '360', 'name' => '苗栗市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '造橋鄉', 'code' => '361', 'name' => '造橋鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '頭屋鄉', 'code' => '362', 'name' => '頭屋鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '公館鄉', 'code' => '363', 'name' => '公館鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '大湖鄉', 'code' => '364', 'name' => '大湖鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '泰安鄉', 'code' => '365', 'name' => '泰安鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '銅鑼鄉', 'code' => '366', 'name' => '銅鑼鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '三義鄉', 'code' => '367', 'name' => '三義鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '西湖鄉', 'code' => '368', 'name' => '西湖鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 7, 'title' => '卓蘭鎮', 'code' => '369', 'name' => '卓蘭鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '中區', 'code' => '400', 'name' => '中區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '東區', 'code' => '401', 'name' => '東區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '南區', 'code' => '402', 'name' => '南區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '西區', 'code' => '403', 'name' => '西區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '北區', 'code' => '404', 'name' => '北區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '北屯區', 'code' => '406', 'name' => '北屯區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '西屯區', 'code' => '407', 'name' => '西屯區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '南屯區', 'code' => '408', 'name' => '南屯區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '太平區', 'code' => '411', 'name' => '太平區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '大里區', 'code' => '412', 'name' => '大里區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '霧峰區', 'code' => '413', 'name' => '霧峰區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '烏日區', 'code' => '414', 'name' => '烏日區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '豐原區', 'code' => '420', 'name' => '豐原區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '后里區', 'code' => '421', 'name' => '后里區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '石岡區', 'code' => '422', 'name' => '石岡區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '東勢區', 'code' => '423', 'name' => '東勢區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '和平區', 'code' => '424', 'name' => '和平區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '新社區', 'code' => '426', 'name' => '新社區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '潭子區', 'code' => '427', 'name' => '潭子區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '大雅區', 'code' => '428', 'name' => '大雅區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '神岡區', 'code' => '429', 'name' => '神岡區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '大肚區', 'code' => '432', 'name' => '大肚區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '沙鹿區', 'code' => '433', 'name' => '沙鹿區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '龍井區', 'code' => '434', 'name' => '龍井區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '梧棲區', 'code' => '435', 'name' => '梧棲區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '清水區', 'code' => '436', 'name' => '清水區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '大甲區', 'code' => '437', 'name' => '大甲區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '外埔區', 'code' => '438', 'name' => '外埔區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 8, 'title' => '大安區', 'code' => '439', 'name' => '大安區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '彰化市', 'code' => '500', 'name' => '彰化市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '芬園鄉', 'code' => '502', 'name' => '芬園鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '花壇鄉', 'code' => '503', 'name' => '花壇鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '秀水鄉', 'code' => '504', 'name' => '秀水鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '鹿港鎮', 'code' => '505', 'name' => '鹿港鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '福興鄉', 'code' => '506', 'name' => '福興鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '線西鄉', 'code' => '507', 'name' => '線西鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '和美鎮', 'code' => '508', 'name' => '和美鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '伸港鄉', 'code' => '509', 'name' => '伸港鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '員林市', 'code' => '510', 'name' => '員林市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '社頭鄉', 'code' => '511', 'name' => '社頭鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '永靖鄉', 'code' => '512', 'name' => '永靖鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '埔心鄉', 'code' => '513', 'name' => '埔心鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '溪湖鎮', 'code' => '514', 'name' => '溪湖鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '大村鄉', 'code' => '515', 'name' => '大村鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '埔鹽鄉', 'code' => '516', 'name' => '埔鹽鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '田中鎮', 'code' => '520', 'name' => '田中鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '北斗鎮', 'code' => '521', 'name' => '北斗鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '田尾鄉', 'code' => '522', 'name' => '田尾鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '埤頭鄉', 'code' => '523', 'name' => '埤頭鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '溪州鄉', 'code' => '524', 'name' => '溪州鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '竹塘鄉', 'code' => '525', 'name' => '竹塘鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '二林鎮', 'code' => '526', 'name' => '二林鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '大城鄉', 'code' => '527', 'name' => '大城鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '芳苑鄉', 'code' => '528', 'name' => '芳苑鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 9, 'title' => '二水鄉', 'code' => '530', 'name' => '二水鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '南投市', 'code' => '540', 'name' => '南投市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '中寮鄉', 'code' => '541', 'name' => '中寮鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '草屯鎮', 'code' => '542', 'name' => '草屯鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '國姓鄉', 'code' => '544', 'name' => '國姓鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '埔里鎮', 'code' => '545', 'name' => '埔里鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '仁愛鄉', 'code' => '546', 'name' => '仁愛鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '名間鄉', 'code' => '551', 'name' => '名間鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '集集鎮', 'code' => '552', 'name' => '集集鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '水里鄉', 'code' => '553', 'name' => '水里鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '魚池鄉', 'code' => '555', 'name' => '魚池鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '信義鄉', 'code' => '556', 'name' => '信義鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '竹山鎮', 'code' => '557', 'name' => '竹山鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 10, 'title' => '鹿谷鄉', 'code' => '558', 'name' => '鹿谷鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '斗南鎮', 'code' => '630', 'name' => '斗南鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '大埤鄉', 'code' => '631', 'name' => '大埤鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '虎尾鎮', 'code' => '632', 'name' => '虎尾鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '土庫鎮', 'code' => '633', 'name' => '土庫鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '褒忠鄉', 'code' => '634', 'name' => '褒忠鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '東勢鄉', 'code' => '635', 'name' => '東勢鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '臺西鄉', 'code' => '636', 'name' => '臺西鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '崙背鄉', 'code' => '637', 'name' => '崙背鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '麥寮鄉', 'code' => '638', 'name' => '麥寮鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '斗六市', 'code' => '640', 'name' => '斗六市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '林內鄉', 'code' => '643', 'name' => '林內鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '古坑鄉', 'code' => '646', 'name' => '古坑鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '莿桐鄉', 'code' => '647', 'name' => '莿桐鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '西螺鎮', 'code' => '648', 'name' => '西螺鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '二崙鄉', 'code' => '649', 'name' => '二崙鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '北港鎮', 'code' => '651', 'name' => '北港鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '水林鄉', 'code' => '652', 'name' => '水林鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '口湖鄉', 'code' => '653', 'name' => '口湖鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '四湖鄉', 'code' => '654', 'name' => '四湖鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 11, 'title' => '元長鄉', 'code' => '655', 'name' => '元長鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 12, 'title' => '東區', 'code' => '600', 'name' => '東區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 12, 'title' => '西區', 'code' => '600', 'name' => '西區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '番路鄉', 'code' => '602', 'name' => '番路鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '梅山鄉', 'code' => '603', 'name' => '梅山鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '竹崎鄉', 'code' => '604', 'name' => '竹崎鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '阿里山鄉', 'code' => '605', 'name' => '阿里山鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '中埔鄉', 'code' => '606', 'name' => '中埔鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '大埔鄉', 'code' => '607', 'name' => '大埔鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '水上鄉', 'code' => '608', 'name' => '水上鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '鹿草鄉', 'code' => '611', 'name' => '鹿草鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '太保市', 'code' => '612', 'name' => '太保市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '朴子市', 'code' => '613', 'name' => '朴子市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '東石鄉', 'code' => '614', 'name' => '東石鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '六腳鄉', 'code' => '615', 'name' => '六腳鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '新港鄉', 'code' => '616', 'name' => '新港鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '民雄鄉', 'code' => '621', 'name' => '民雄鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '大林鎮', 'code' => '622', 'name' => '大林鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '溪口鄉', 'code' => '623', 'name' => '溪口鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '義竹鄉', 'code' => '624', 'name' => '義竹鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 13, 'title' => '布袋鎮', 'code' => '625', 'name' => '布袋鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '中西區', 'code' => '700', 'name' => '中西區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '東區', 'code' => '701', 'name' => '東區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '南區', 'code' => '702', 'name' => '南區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '北區', 'code' => '704', 'name' => '北區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '安平區', 'code' => '708', 'name' => '安平區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '安南區', 'code' => '709', 'name' => '安南區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '永康區', 'code' => '710', 'name' => '永康區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '歸仁區', 'code' => '711', 'name' => '歸仁區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '新化區', 'code' => '712', 'name' => '新化區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '左鎮區', 'code' => '713', 'name' => '左鎮區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '玉井區', 'code' => '714', 'name' => '玉井區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '楠西區', 'code' => '715', 'name' => '楠西區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '南化區', 'code' => '716', 'name' => '南化區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '仁德區', 'code' => '717', 'name' => '仁德區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '關廟區', 'code' => '718', 'name' => '關廟區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '龍崎區', 'code' => '719', 'name' => '龍崎區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '官田區', 'code' => '720', 'name' => '官田區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '麻豆區', 'code' => '721', 'name' => '麻豆區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '佳里區', 'code' => '722', 'name' => '佳里區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '西港區', 'code' => '723', 'name' => '西港區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '七股區', 'code' => '724', 'name' => '七股區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '將軍區', 'code' => '725', 'name' => '將軍區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '學甲區', 'code' => '726', 'name' => '學甲區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '北門區', 'code' => '727', 'name' => '北門區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '新營區', 'code' => '730', 'name' => '新營區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '後壁區', 'code' => '731', 'name' => '後壁區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '白河區', 'code' => '732', 'name' => '白河區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '東山區', 'code' => '733', 'name' => '東山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '六甲區', 'code' => '734', 'name' => '六甲區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '下營區', 'code' => '735', 'name' => '下營區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '柳營區', 'code' => '736', 'name' => '柳營區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '鹽水區', 'code' => '737', 'name' => '鹽水區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '善化區', 'code' => '741', 'name' => '善化區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '大內區', 'code' => '742', 'name' => '大內區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '山上區', 'code' => '743', 'name' => '山上區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '新市區', 'code' => '744', 'name' => '新市區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 14, 'title' => '安定區', 'code' => '745', 'name' => '安定區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '新興區', 'code' => '800', 'name' => '新興區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '前金區', 'code' => '801', 'name' => '前金區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '苓雅區', 'code' => '802', 'name' => '苓雅區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '鹽埕區', 'code' => '803', 'name' => '鹽埕區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '鼓山區', 'code' => '804', 'name' => '鼓山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '旗津區', 'code' => '805', 'name' => '旗津區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '前鎮區', 'code' => '806', 'name' => '前鎮區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '三民區', 'code' => '807', 'name' => '三民區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '楠梓區', 'code' => '811', 'name' => '楠梓區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '小港區', 'code' => '812', 'name' => '小港區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '左營區', 'code' => '813', 'name' => '左營區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '仁武區', 'code' => '814', 'name' => '仁武區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '大社區', 'code' => '815', 'name' => '大社區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '東沙群島', 'code' => '817', 'name' => '東沙群島', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '南沙群島', 'code' => '819', 'name' => '南沙群島', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '岡山區', 'code' => '820', 'name' => '岡山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '路竹區', 'code' => '821', 'name' => '路竹區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '阿蓮區', 'code' => '822', 'name' => '阿蓮區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '田寮區', 'code' => '823', 'name' => '田寮區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '燕巢區', 'code' => '824', 'name' => '燕巢區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '橋頭區', 'code' => '825', 'name' => '橋頭區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '梓官區', 'code' => '826', 'name' => '梓官區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '彌陀區', 'code' => '827', 'name' => '彌陀區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '永安區', 'code' => '828', 'name' => '永安區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '湖內區', 'code' => '829', 'name' => '湖內區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '鳳山區', 'code' => '830', 'name' => '鳳山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '大寮區', 'code' => '831', 'name' => '大寮區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '林園區', 'code' => '832', 'name' => '林園區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '鳥松區', 'code' => '833', 'name' => '鳥松區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '大樹區', 'code' => '840', 'name' => '大樹區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '旗山區', 'code' => '842', 'name' => '旗山區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '美濃區', 'code' => '843', 'name' => '美濃區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '六龜區', 'code' => '844', 'name' => '六龜區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '內門區', 'code' => '845', 'name' => '內門區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '杉林區', 'code' => '846', 'name' => '杉林區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '甲仙區', 'code' => '847', 'name' => '甲仙區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '桃源區', 'code' => '848', 'name' => '桃源區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '那瑪夏區', 'code' => '849', 'name' => '那瑪夏區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '茂林區', 'code' => '851', 'name' => '茂林區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 15, 'title' => '茄萣區', 'code' => '852', 'name' => '茄萣區', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '屏東市', 'code' => '900', 'name' => '屏東市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '三地門鄉', 'code' => '901', 'name' => '三地門鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '霧臺鄉', 'code' => '902', 'name' => '霧臺鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '瑪家鄉', 'code' => '903', 'name' => '瑪家鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '九如鄉', 'code' => '904', 'name' => '九如鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '里港鄉', 'code' => '905', 'name' => '里港鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '高樹鄉', 'code' => '906', 'name' => '高樹鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '鹽埔鄉', 'code' => '907', 'name' => '鹽埔鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '長治鄉', 'code' => '908', 'name' => '長治鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '麟洛鄉', 'code' => '909', 'name' => '麟洛鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '竹田鄉', 'code' => '911', 'name' => '竹田鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '內埔鄉', 'code' => '912', 'name' => '內埔鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '萬丹鄉', 'code' => '913', 'name' => '萬丹鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '潮州鎮', 'code' => '920', 'name' => '潮州鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '泰武鄉', 'code' => '921', 'name' => '泰武鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '來義鄉', 'code' => '922', 'name' => '來義鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '萬巒鄉', 'code' => '923', 'name' => '萬巒鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '崁頂鄉', 'code' => '924', 'name' => '崁頂鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '新埤鄉', 'code' => '925', 'name' => '新埤鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '南州鄉', 'code' => '926', 'name' => '南州鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '林邊鄉', 'code' => '927', 'name' => '林邊鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '東港鎮', 'code' => '928', 'name' => '東港鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '琉球鄉', 'code' => '929', 'name' => '琉球鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '佳冬鄉', 'code' => '931', 'name' => '佳冬鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '新園鄉', 'code' => '932', 'name' => '新園鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '枋寮鄉', 'code' => '940', 'name' => '枋寮鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '枋山鄉', 'code' => '941', 'name' => '枋山鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '春日鄉', 'code' => '942', 'name' => '春日鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '獅子鄉', 'code' => '943', 'name' => '獅子鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '車城鄉', 'code' => '944', 'name' => '車城鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '牡丹鄉', 'code' => '945', 'name' => '牡丹鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '恆春鎮', 'code' => '946', 'name' => '恆春鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 16, 'title' => '滿州鄉', 'code' => '947', 'name' => '滿州鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '臺東市', 'code' => '950', 'name' => '臺東市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '綠島鄉', 'code' => '951', 'name' => '綠島鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '蘭嶼鄉', 'code' => '952', 'name' => '蘭嶼鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '延平鄉', 'code' => '953', 'name' => '延平鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '卑南鄉', 'code' => '954', 'name' => '卑南鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '鹿野鄉', 'code' => '955', 'name' => '鹿野鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '關山鎮', 'code' => '956', 'name' => '關山鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '海端鄉', 'code' => '957', 'name' => '海端鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '池上鄉', 'code' => '958', 'name' => '池上鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '東河鄉', 'code' => '959', 'name' => '東河鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '成功鎮', 'code' => '961', 'name' => '成功鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '長濱鄉', 'code' => '962', 'name' => '長濱鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '太麻里鄉', 'code' => '963', 'name' => '太麻里鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '金峰鄉', 'code' => '964', 'name' => '金峰鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '大武鄉', 'code' => '965', 'name' => '大武鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 17, 'title' => '達仁鄉', 'code' => '966', 'name' => '達仁鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '花蓮市', 'code' => '970', 'name' => '花蓮市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '新城鄉', 'code' => '971', 'name' => '新城鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '秀林鄉', 'code' => '972', 'name' => '秀林鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '吉安鄉', 'code' => '973', 'name' => '吉安鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '壽豐鄉', 'code' => '974', 'name' => '壽豐鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '鳳林鎮', 'code' => '975', 'name' => '鳳林鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '光復鄉', 'code' => '976', 'name' => '光復鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '豐濱鄉', 'code' => '977', 'name' => '豐濱鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '瑞穗鄉', 'code' => '978', 'name' => '瑞穗鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '萬榮鄉', 'code' => '979', 'name' => '萬榮鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '玉里鎮', 'code' => '981', 'name' => '玉里鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '卓溪鄉', 'code' => '982', 'name' => '卓溪鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 18, 'title' => '富里鄉', 'code' => '983', 'name' => '富里鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '宜蘭市', 'code' => '260', 'name' => '宜蘭市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '頭城鎮', 'code' => '261', 'name' => '頭城鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '礁溪鄉', 'code' => '262', 'name' => '礁溪鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '壯圍鄉', 'code' => '263', 'name' => '壯圍鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '員山鄉', 'code' => '264', 'name' => '員山鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '羅東鎮', 'code' => '265', 'name' => '羅東鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '三星鄉', 'code' => '266', 'name' => '三星鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '大同鄉', 'code' => '267', 'name' => '大同鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '五結鄉', 'code' => '268', 'name' => '五結鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '冬山鄉', 'code' => '269', 'name' => '冬山鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '蘇澳鎮', 'code' => '270', 'name' => '蘇澳鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '南澳鄉', 'code' => '272', 'name' => '南澳鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 19, 'title' => '釣魚臺', 'code' => '290', 'name' => '釣魚臺', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 20, 'title' => '馬公市', 'code' => '880', 'name' => '馬公市', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 20, 'title' => '西嶼鄉', 'code' => '881', 'name' => '西嶼鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 20, 'title' => '望安鄉', 'code' => '882', 'name' => '望安鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 20, 'title' => '七美鄉', 'code' => '883', 'name' => '七美鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 20, 'title' => '白沙鄉', 'code' => '884', 'name' => '白沙鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 20, 'title' => '湖西鄉', 'code' => '885', 'name' => '湖西鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 21, 'title' => '金沙鎮', 'code' => '890', 'name' => '金沙鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 21, 'title' => '金湖鎮', 'code' => '891', 'name' => '金湖鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 21, 'title' => '金寧鄉', 'code' => '892', 'name' => '金寧鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 21, 'title' => '金城鎮', 'code' => '893', 'name' => '金城鎮', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 21, 'title' => '烈嶼鄉', 'code' => '894', 'name' => '烈嶼鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 21, 'title' => '烏坵鄉', 'code' => '896', 'name' => '烏坵鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 22, 'title' => '南竿鄉', 'code' => '209', 'name' => '南竿鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 22, 'title' => '北竿鄉', 'code' => '210', 'name' => '北竿鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 22, 'title' => '莒光鄉', 'code' => '211', 'name' => '莒光鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['state_id' => 22, 'title' => '東引鄉', 'code' => '212', 'name' => '東引鄉', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            //['state_id' => 23, 'title' => '東沙群島', 'code' => '817', 'name' => '東沙群島', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            //['state_id' => 23, 'title' => '南沙群島', 'code' => '819', 'name' => '南沙群島', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            //['state_id' => 24, 'title' => '釣魚臺', 'code' => '290', 'name' => '釣魚臺', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];

        foreach ($cityData as $key => $item) {
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'world_city.name.' . ($key + 1), 'text' => $item['name'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            $cityData[$key]['name'] = 'world_city.name.' . ($key + 1);
        }

        DB::table('world_city')->insert($cityData);

        $bankData = [
            ['country_id' => 1, 'title' => '臺灣銀行', 'code' => '004', 'name' => '臺灣銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '土地銀行', 'code' => '005', 'name' => '土地銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '合作金庫商業銀行', 'code' => '006', 'name' => '合作金庫商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '第一商業銀行', 'code' => '007', 'name' => '第一商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '華南商業銀行', 'code' => '008', 'name' => '華南商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '彰化商業銀行', 'code' => '009', 'name' => '彰化商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '上海商業儲蓄銀行', 'code' => '011', 'name' => '上海商業儲蓄銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '台北富邦商業銀行', 'code' => '012', 'name' => '台北富邦商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '國泰世華商業銀行', 'code' => '013', 'name' => '國泰世華商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '中國輸出入銀行', 'code' => '015', 'name' => '中國輸出入銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '高雄銀行', 'code' => '016', 'name' => '高雄銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '兆豐國際商業銀行', 'code' => '017', 'name' => '兆豐國際商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '全國農業金庫', 'code' => '018', 'name' => '全國農業金庫', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '花旗（台灣）商業銀行', 'code' => '021', 'name' => '花旗（台灣）商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '澳盛（台灣）商業銀行', 'code' => '039', 'name' => '澳盛（台灣）商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '王道商業銀行', 'code' => '048', 'name' => '王道商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '臺灣中小企業銀行', 'code' => '050', 'name' => '臺灣中小企業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '渣打國際商業銀行', 'code' => '052', 'name' => '渣打國際商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '台中商業銀行', 'code' => '053', 'name' => '台中商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '京城商業銀行', 'code' => '054', 'name' => '京城商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '滙豐（台灣）商業銀行', 'code' => '081', 'name' => '滙豐（台灣）商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '瑞興商業銀行', 'code' => '101', 'name' => '瑞興商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '華泰商業銀行', 'code' => '102', 'name' => '華泰商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '臺灣新光商業銀行', 'code' => '103', 'name' => '臺灣新光商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '陽信商業銀行', 'code' => '108', 'name' => '陽信商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '板信商業銀行', 'code' => '118', 'name' => '板信商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '三信商業銀行', 'code' => '147', 'name' => '三信商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '中華郵政', 'code' => '700', 'name' => '中華郵政', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '聯邦商業銀行', 'code' => '803', 'name' => '聯邦商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '遠東國際商業銀行', 'code' => '805', 'name' => '遠東國際商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '元大商業銀行', 'code' => '806', 'name' => '元大商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '永豐商業銀行', 'code' => '807', 'name' => '永豐商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '玉山商業銀行', 'code' => '808', 'name' => '玉山商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '凱基商業銀行', 'code' => '809', 'name' => '凱基商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '星展（台灣）商業銀行', 'code' => '810', 'name' => '星展（台灣）商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '台新國際商業銀行', 'code' => '812', 'name' => '台新國際商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '日盛國際商業銀行', 'code' => '815', 'name' => '日盛國際商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '安泰商業銀行', 'code' => '816', 'name' => '安泰商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['country_id' => 1, 'title' => '中國信託商業銀行', 'code' => '822', 'name' => '中國信託商業銀行', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ];

        foreach ($bankData as $key => $item) {
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'bank.name.' . ($key + 1), 'text' => $item['name'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            $bankData[$key]['name'] = 'bank.name.' . ($key + 1);
        }

        DB::table('bank')->insert($bankData);

        $webData = [
            [
                'guid' => uuidl(),
                'guard' => 'administrator',
                'website_name' => '總後臺管理系統',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url') . '/administrator',
                'system_logo' => json_encode([[
                    'path' => 'admin/images/logo-b.png',
                    'alt' => ''
                ]]),
                'company' => json_encode([
                    'name' => '雲端數位科技',
                    'name_en' => 'MinMax',
                    'id' => '24252151'
                ]),
                'contact' => json_encode([
                    'phone' => '04-24350749',
                    'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62',
                    'lng' => '',
                    'lat' => '',
                ]),
                'social' => json_encode([
                    'facebook' => '',
                    'youtube' => '',
                    'instagram' => '',
                ]),
                'seo' => json_encode([
                    'meta_description' => '',
                    'meta_keywords' => '',
                ]),
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'guid' => uuidl(),
                'guard' => 'admin',
                'website_name' => '後臺管理系統',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url') . '/siteadmin',
                'system_logo' => json_encode([[
                    'path' => 'admin/images/logo-b.png',
                    'alt' => ''
                ]]),
                'company' => json_encode([
                    'name' => '雲端數位科技',
                    'name_en' => 'MinMax',
                    'id' => '24252151'
                ]),
                'contact' => json_encode([
                    'phone' => '04-24350749',
                    'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62',
                    'lng' => '',
                    'lat' => '',
                ]),
                'social' => json_encode([
                    'facebook' => 'https://www.facebook.com',
                    'youtube' => 'https://www.youtube.com',
                    'instagram' => 'https://www.instagram.com',
                ]),
                'seo' => json_encode([
                    'meta_description' => '',
                    'meta_keywords' => '',
                ]),
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'guid' => uuidl(),
                'guard' => 'web',
                'website_name' => '後臺管理系統',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url'),
                'system_logo' => json_encode([[
                    'path' => 'admin/images/logo-b.png',
                    'alt' => ''
                ]]),
                'company' => json_encode([
                    'name' => '雲端數位科技',
                    'name_en' => 'MinMax',
                    'id' => '24252151'
                ]),
                'contact' => json_encode([
                    'phone' => '04-24350749',
                    'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62',
                    'lng' => '',
                    'lat' => '',
                ]),
                'social' => json_encode([
                    'facebook' => 'https://www.facebook.com',
                    'youtube' => 'https://www.youtube.com',
                    'instagram' => 'https://www.instagram.com',
                ]),
                'seo' => json_encode([
                    'meta_description' => '',
                    'meta_keywords' => '',
                ]),
                'active' => '1',
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ];

        foreach ($webData as $key => $item) {
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'web_data.company.' . ($key + 1), 'text' => $item['company'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'web_data.contact.' . ($key + 1), 'text' => $item['contact'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'web_data.seo.' . ($key + 1), 'text' => $item['seo'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            array_push($languageResourceData, ['language_id' => 1, 'key' => 'web_data.offline_text.' . ($key + 1), 'text' => $item['offline_text'] ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp]);
            $webData[$key]['company'] = 'web_data.company.' . ($key + 1);
            $webData[$key]['contact'] = 'web_data.contact.' . ($key + 1);
            $webData[$key]['seo'] = 'web_data.seo.' . ($key + 1);
            $webData[$key]['offline_text'] = 'web_data.offline_text.' . ($key + 1);
        }

        DB::table('web_data')->insert($webData);

        $parametersData = [
            [
                'code' => 'active',
                'title' => '啟用狀態',
                'options' => json_encode([
                    ['label' => '啟用', 'value' => '1', 'class' => 'danger'],
                    ['label' => '停用', 'value' => '0', 'class' => 'secondary']
                ]),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'code' => 'result',
                'title' => '操作結果',
                'options' => json_encode([
                    ['label' => '成功', 'value' => '1', 'class' => 'success'],
                    ['label' => '失敗', 'value' => '0', 'class' => 'danger']
                ]),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'code' => 'rule',
                'title' => '防火牆規則',
                'options' => json_encode([
                    ['label' => '允許', 'value' => '1', 'class' => 'success'],
                    ['label' => '禁止', 'value' => '0', 'class' => 'danger']
                ]),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ];
        DB::table('system_parameter')->insert($parametersData);

        try {
            $emailTemplate1 = view('emails.templates.email-normal')->render();
        } catch (\Exception $e) {
            $emailTemplate1 = '';
        }

        $editorTemplateData = [
            [
                'guard' => 'admin',
                'category' => 'email',
                'title' => '電子郵件-普通',
                'description' => '普通系統訊息通知信件',
                'editor' => $emailTemplate1,
                'sort' => '1',
                'active' => '1',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ];
        DB::table('editor_template')->insert($editorTemplateData);

        // 儲存語系文件
        DB::table('language_resource')->insert($languageResourceData);
    }
}
