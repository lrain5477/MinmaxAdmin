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

    'AdvertisingCategory' => [
        'id' => 'ID',
        'code' => '版位代碼',
        'title' => '版位名稱',
        'remark' => '備註',
        'ad_type' => '廣告種類',
        'options' => '版位設定',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'code' => '使用此唯一代碼識別不同的版位。',
        ],
        'amount' => '廣告數',
    ],

    'Advertising' => [
        'id' => 'ID',
        'category_id' => '廣告版位',
        'title' => '廣告名稱',
        'target' => '目標視窗',
        'link' => '連結網址',
        'details' => '詳細內容',
        'start_at' => '發佈時間',
        'end_at' => '下架時間',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'start_at' => '如果需要在未來期限到後自動上架刊登，請在此設定一個日期。',
            'end_at' => '如果需要在有效期限過後自動下架刊登，請在此設定一個日期。',
        ],
        'count' => '點擊',
    ],

];