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

    'ArticleNews' => [
        'id' => 'ID',
        'uri' => '自訂連結',
        'title' => '新聞標題',
        'description' => '簡短敘述',
        'editor' => '新聞內容',
        'pic' => '新聞圖片',
        'start_at' => '發佈時間',
        'end_at' => '下架時間',
        'seo' => [
            'meta_description' => 'SEO 網站描述',
            'meta_keywords' => 'SEO 關鍵字',
        ],
        'top' => '置頂狀態',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'uri' => '自訂分類連結名稱，此名稱為唯一值。',
            'start_at' => '如果需要在未來期限到後自動上架刊登，請在此設定一個日期。',
            'end_at' => '如果需要在有效期限過後自動下架刊登，請在此設定一個日期。',
            'seo' => [
                'meta_description' => '(Metadata Description) 利用簡短的說明讓人清楚的了解網站的主要內容、簡介方向等，搜尋引擎將會幫我們適當的顯示在介紹頁面上。',
                'meta_keywords' => '(Metadata Keywords) 為了幫助搜尋引擎更容易搜尋到網站，你可以在這裡填寫相關的搜尋字詞，多組關鍵字以上請使用半形逗號區隔。',
            ],
            'categories' => '一篇新聞可以放置於多個分類中。',
        ],
        'categories' => '新聞類別',
        'count' => '瀏覽次數',
    ],

    'ArticleCategory' => [
        'id' => 'ID',
        'uri' => '自訂連結',
        'parent_id' => '上層類別',
        'title' => '類別名稱',
        'details' => '詳細內容',
        'options' => '類別設定',
        'seo' => 'SEO',
        'sort' => '排序',
        'editable' => '可否編輯',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'uri' => '自訂分類連結名稱，此名稱為唯一值。',
        ],
        'obj_amount' => '數量',
        'sub_amount' => '子類數',
    ],

];