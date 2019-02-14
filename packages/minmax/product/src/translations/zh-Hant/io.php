<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Io Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the system text in backend platform page.
    |
    */

    'fieldSet' => [
        'filter' => '條件篩選',
        'sort' => '資料排序',
    ],

    'ProductItem' => [
        'import' => [
            'file_label' => '來源檔案',
            'override_label' => '覆寫存在檔案',
            'download_label' => '下載結果報表',
            'options' => [
                'override' => [
                    '1' => '啟用',
                    '0' => '停用',
                ],
                'download' => [
                    '1' => '啟用',
                    '0' => '停用',
                ],
            ],
            'hint' => [
                'file' => '支援上傳 xlsx 檔案格式，請 <a href=":link" target="_blank">點選此處下載</a> 範例檔案',
                'override' => '覆寫將會比對 <code>品項貨號</code> (第一欄)，其他所有欄位資料都將會被覆蓋。'
            ],
        ],
        'export' => [
            'created_at_label' => '建立日期',
            'updated_at_label' => '更新日期',
            'active_label' => '啟用狀態',
            'sort_label' => '排序欄位',
            'arrange_label' => '排列方式',
            'options' => [
                'active' => [
                    'all' => '全部',
                    '1' => '啟用',
                    '0' => '停用',
                ],
                'arrange' => [
                    'asc' => '升冪',
                    'desc' => '降冪',
                ],
            ],
        ],
    ],

];