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

    'ProductCategory' => [
        'id' => 'ID',
        'title' => '分類名稱',
        'details' => [
            'pic' => '分類圖片',
            'description' => '說明文字',
            'editor' => '詳細內容',
        ],
        'parent_id' => '上層分類',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'details' => [
                'pic' => '建議尺寸：480px * 480px。圖片類型：jpg、png。數量限制：1張。',
            ],
        ],
    ],

    'ProductItem' => [
        'id' => 'ID',
        'sku' => '品項貨號',
        'serial' => '原廠貨號',
        'title' => '品項名稱',
        'pic' => '品項圖片',
        'details' => [
            'description' => '說明文字',
            'editor' => '詳細內容',
        ],
        'cost' => '成本金額',
        'price' => '安全單價',
        'qty_enable' => '庫存管理',
        'qty_safety' => '安全庫存',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'sku' => '品項貨號是品項的唯一識別碼，不可與其他品項重複。',
            'serial' => '若您的商品有不同的貨號格式，可於此欄位紀錄。',
            'pic' => '建議尺寸：800px * 800px。圖片類型：jpg、png。數量限制：1張。',
        ],
        'qty' => '庫存',
        'money' => '價格設定',
    ],

    'ProductMarket' => [
        'id' => 'ID',
        'code' => '賣場代碼',
        'title' => '賣場名稱',
        'admin_id' => '管理員',
        'details' => [
            'editor' => '詳細內容',
            'pic' => '賣場圖片',
        ],
        'options' => [],
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'code' => '賣場代碼是唯一代碼，不可與其他賣場重複。',
            'details' => [
                'pic' => '建議尺寸：800px * 800px。圖片類型：jpg、png。數量限制：1張。',
            ],
        ],
    ],

    'ProductBrand' => [
        'id' => 'ID',
        'title' => '品牌名稱',
        'pic' => '品牌圖片',
        'details' => [
            'description' => '說明文字',
            'editor' => '詳細內容',
        ],
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'pic' => '建議尺寸：320px * 90px。圖片類型：jpg、png。數量限制：1張。',
        ],
    ],

];