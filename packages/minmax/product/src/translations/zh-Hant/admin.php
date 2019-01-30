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
    ],

    'form' => [
        'ProductItem' => [
            'money' => '價格設定',
            'currency' => '貨幣別',
            'actions' => '執行',
            'please_select' => '請選擇',
        ],
        'ProductSet' => [
            'please_select' => '請選擇',
        ],
    ],

];