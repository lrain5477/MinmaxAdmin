<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models (Database Column) Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the system text in backend platform page.
    |
    */

    'WorldContinent' => [
        'id' => 'ID',
        'title' => '大洲名稱',
        'code' => '大洲代碼',
        'name' => '顯示文字',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'WorldCountry' => [
        'id' => 'ID',
        'continent_id' => '隸屬大洲',
        'title' => '國家名稱',
        'code' => '國家代碼',
        'name' => '顯示文字',
        'icon' => '圖示代碼',
        'language_id' => '語系',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'icon' => '請參考連結選擇您所需要的圖示 <a target="_blank" href="/static/admin/css/fonts/flag/index.html">圖示列表</a>',
        ],
    ],

    'WorldState' => [
        'id' => 'ID',
        'country_id' => '隸屬國家',
        'title' => '州區名稱',
        'code' => '州區代碼',
        'name' => '顯示文字',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'WorldCounty' => [
        'id' => 'ID',
        'state_id' => '隸屬州區',
        'title' => '縣市名稱',
        'code' => '縣市代碼',
        'name' => '顯示文字',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'WorldCity' => [
        'id' => 'ID',
        'county_id' => '隸屬縣市',
        'title' => '城市名稱',
        'code' => '城市代碼',
        'name' => '顯示文字',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'WorldBank' => [
        'id' => 'ID',
        'country_id' => '隸屬國家',
        'title' => '銀行名稱',
        'code' => '銀行代碼',
        'name' => '顯示文字',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'WorldCurrency' => [
        'id' => 'ID',
        'title' => '貨幣名稱',
        'code' => '貨幣代碼',
        'name' => '顯示文字',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

];