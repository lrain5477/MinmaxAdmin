<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the system text in admin page.
    |
    */

    'grid' => [
        'ProductItem' => [
            'tags' => [
                'title' => '標籤全部',
                'qty_safety' => '庫存警示',
                'qty_empty' => '無庫存',
                'package_empty' => '無商品',
            ],
            'relation' => '關聯',
            'relations' => [
                'set' => '商品',
                'package' => '組合',
            ],
        ],
        'ProductSet' => [
            'tags' => [
                'title' => '標籤全部',
                'qty_safety' => '庫存警示',
                'qty_empty' => '無庫存',
                'package_empty' => '無品項',
            ],
            'relation' => '關聯',
            'relations' => [
                'item' => '品項',
                'package' => '組合',
                'specification' => '規格',
            ],
        ],
        'ProductPackage' => [
            'all_market' => '所有賣場',
            'title' => '商品名稱',
        ],
        'ProductCategory' => [
            'set_amount' => '商品數',
            'sub_amount' => '子類數',
        ],
    ],

    'form' => [
        'update_qty' => '異動庫存',
        'fieldSet' => [
            'spec' => '規格設定',
            'ecommerce' => '購物車屬性',
        ],
        'ProductItem' => [
            'money' => '價格設定',
            'currency' => '貨幣別',
            'actions' => '動作',
            'please_select' => '請選擇',
            'messages' => [
                'manual_update_qty' => '手動更新庫存。',
                'qty_success_title' => '更新庫存成功',
                'qty_success_text' => '您已成功更新庫存。',
                'qty_nothing_title' => '庫存未更新',
                'qty_nothing_text' => '沒有任何項目的庫存更新。',
                'qty_no_change_title' => '庫存未更新',
                'qty_no_change_text' => '您並沒有更動庫存數量，無法更新。',
            ],
        ],
        'ProductSet' => [
            'specification_name' => '規格名稱',
            'specification_value' => '規格內容',
            'actions' => '動作',
            'please_select' => '請選擇',
        ],
        'ProductPackage' => [
            'price' => '價格設定',
            'currency' => '貨幣別',
            'actions' => '動作',
            'please_select' => '請選擇',
        ],
    ],

];