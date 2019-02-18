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
            'comments' => [
                'sku' => '必填。品項的唯一代碼，不可與其他品項重複。',
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

    'ProductSet' => [
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
                'override' => '覆寫將會比對 <code>商品貨號</code> (第一欄)，其他所有欄位資料都將會被覆蓋。'
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
            'comments' => [
                'sku' => '必填。品項的唯一代碼，不可與其他品項重複。',
                'title' => '必填。',
                'brand_id' => '請參考品牌表填入ID。',
                'categories' => '必填。請參考商品分類表填入ID。可使用半形逗號分隔填寫多個分類。',
                'pic' => '請填寫圖片相對路徑。可使用半形逗號分隔填寫多張圖片。',
                'html' => '可使用 HTML 程式碼。',
                'rank' => '必填。請填寫 0-5 的數字。0 表示自動。',
                'tags' => '請參考關聯標籤表填寫文字。可使用半形逗號分隔填寫多個標籤。若標籤不存在於系統，將會自動新增。',
                'spec_group' => '填寫相同的群組代碼將會綁定為同一規格群組。',
                'specifications' => '請參考產品規格表填入ID。可使用半形逗號分隔填寫多個規格。同一規格類別只可填寫一個規格項目。',
                'ec_parameters' => '請參考購物車屬性表填入ID。',
                'required' => '必填。',
                'multiple' => '可使用半形逗號分隔填寫多個項目。',
                'properties' => '請參考自訂屬性表填入ID。可使用半形逗號分隔填寫多個屬性。',
                'start_at' => '請輸入格式為 YYYY-MM-DD HH:ii:ss 的日期時間。空白則系統自動帶入匯入時間。',
                'end_at' => '請輸入格式為 YYYY-MM-DD HH:ii:ss 的日期時間。',
                'searchable' => "必填。\r\n1:顯示\r\n0:隱藏",
                'visible' => "必填。\r\n1:顯示\r\n0:隱藏",
                'active' => "必填。\r\n1:啟用\r\n0:停用",
            ],
        ],
    ],

];