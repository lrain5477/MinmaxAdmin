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
            'serial' => '若您的品項有不同的貨號格式，可於此欄位紀錄。',
            'pic' => '建議尺寸：800px * 800px。圖片類型：jpg、png。數量限制：1張。',
        ],
        'qty' => '庫存',
        'money' => '價格設定',
    ],

    'ProductSet' => [
        'id' => 'ID',
        'sku' => '商品貨號',
        'serial' => '原廠貨號',
        'title' => '商品名稱',
        'pic' => '商品圖片',
        'details' => [
            'description' => '簡短敘述',
            'feature' => '商品特色',
            'detail' => '詳細介紹',
            'specification' => '規格資訊',
            'video' => '影音資訊',
            'accessory' => '配件說明',
        ],
        'start_at' => '開始時間',
        'end_at' => '結束時間',
        'brand_id' => '品牌',
        'rank' => '評價分數',
        'spec_group' => '群組代碼',
        'specifications' => '產品規格',
        'tags' => '關聯標籤',
        'seo' => [
            'meta_description' => 'SEO 網站描述',
            'meta_keywords' => 'SEO 關鍵字',
        ],
        'searchable' => '搜尋顯示',
        'visible' => '前臺顯示',
        'properties' => '自訂屬性',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'sku' => '商品貨號是商品的唯一識別碼，不可與其他商品重複。',
            'serial' => '若您的商品有不同的貨號格式，可於此欄位紀錄。',
            'pic' => '建議尺寸：800px * 800px。圖片類型：jpg、png。數量限制：1張。',
            'seo' => [
                'meta_description' => '(Metadata Description) 利用簡短的說明讓人清楚的了解網站的主要內容、簡介方向等，搜尋引擎將會幫我們適當的顯示在介紹頁面上。',
                'meta_keywords' => '(Metadata Keywords) 為了幫助搜尋引擎更容易搜尋到網站，你可以在這裡填寫相關的搜尋字詞，多組關鍵字以上請使用半形逗號區隔。',
            ],
            'rank' => '設定 0 表示系統自動計算。',
            'categories' => '您可以將一商品放置於多個分類顯示。',
        ],
        'price' => '價格',
        'categories' => '商品分類',
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