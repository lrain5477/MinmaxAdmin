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

    'Administrator' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'username' => '帳號',
        'password' => '密碼',
        'password_confirmation' => '密碼確認',
        'name' => '姓名',
        'allow_ip' => 'IP白名單',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
        'hint' => [
            'allow_ip' => '請斷行設定可登入來源IP位置，空白表示可自任何地方登入',
            'password' => '若不需更新密碼，請維持此欄位空白',
            'password_confirmation' => '請再次輸入密碼；若不需更新密碼，請維持此欄位空白',
        ],
    ],

    'Admin' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'role_id' => '權限群組',
        'username' => '帳號',
        'password' => '密碼',
        'password_confirmation' => '密碼確認',
        'name' => '姓名',
        'email' => 'Email',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
        'hint' => [
            'password' => '若不需更新密碼，請維持此欄位空白',
            'password_confirmation' => '請再次輸入密碼；若不需更新密碼，請維持此欄位空白',
        ],
    ],

    'AdminMenuClass' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'title' => '類別名稱',
        'sort' => '排序',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
    ],

    'AdminMenuItem' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => '語系',
        'title' => '選單名稱',
        'uri' => 'Uri',
        'controller' => 'Controller 名稱',
        'model' => 'Model 名稱',
        'class' => '類別',
        'parent' => '上層目錄',
        'link' => '項目連結',
        'icon' => '圖示 Class',
        'filter' => '資料過濾 (where)',
        'keeps' => '不可刪除 GUID',
        'sort' => '排序',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
        'hint' => [
            'icon' => '僅 (根列表) 使用，請參考連結選擇您所需要的圖示 <a target="_blank" href="/admin/css/fonts/icon/demo.html">圖示列表</a>',
        ],
    ],

    'MerchantMenuClass' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'title' => '類別名稱',
        'sort' => '排序',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
    ],

    'MerchantMenuItem' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => '語系',
        'title' => '選單名稱',
        'uri' => 'Uri',
        'model' => 'Model 名稱',
        'class' => '類別',
        'parent' => '上層目錄',
        'link' => '項目連結',
        'icon' => '圖示 Class',
        'filter' => '資料過濾 (where)',
        'keeps' => '不可刪除 GUID',
        'sort' => '排序',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
        'hint' => [
            'icon' => '僅 (根列表) 使用，請參考連結選擇您所需要的圖示 <a target="_blank" href="/admin/css/fonts/icon/demo.html">圖示列表</a>',
        ],
    ],

    'Role' => [
        'id' => 'ID',
        'guard' => '平台',
        'name' => '代碼',
        'display_name' => '角色名稱',
        'description' => '敘述',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
    ],

    'Permission' => [
        'id' => 'ID',
        'guard' => '平台',
        'name' => '代碼',
        'group' => '群組',
        'label' => '標籤',
        'display_name' => '權限名稱',
        'description' => '敘述',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
    ],

    'Language' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'title' => '語系',
        'codes' => '語系代碼',
        'name' => '顯示文字',
        'icon' => '圖示代碼',
        'sort' => '排序',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
    ],

    'Firewall' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'guard' => '網站群組',
        'ip' => 'IP 位址',
        'rule' => '規則',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'rule' => [
                '1' => '允許',
                '0' => '禁止',
            ],
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
    ],

    'WebData' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => '語系',
        'website_name' => '網站名稱',
        'system_email' => '系統信箱',
        'system_url' => '網站網址',
        'company_name' => '公司名稱',
        'company_name_en' => '公司英文名稱',
        'company_id' => '統一編號',
        'phone' => '客服電話',
        'fax' => '傳真號碼',
        'email' => '客服信箱',
        'address' => '公司地址',
        'map_lng' => '地圖經度',
        'map_lat' => '地圖緯度',
        'map_url' => '地址連結',
        'link_facebook' => 'Facebook',
        'link_instagram' => 'Instagram',
        'link_twitter' => 'Twitter',
        'link_gplus' => 'Google+',
        'link_youtube' => 'Youtube',
        'seo_description' => 'SEO 網站描述',
        'seo_keywords' => 'SEO 關鍵字',
        'google_analytics' => 'Google Analytics',
        'active' => '網站狀態',
        'offline_text' => '網站離線訊息',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'seo_description' => '(Metadata Description) 利用簡短的說明讓人清楚的了解網站的主要內容、簡介方向等，搜尋引擎將會幫我們適當的顯示在介紹頁面上。',
            'seo_keywords' => '(Metadata Keywords) 搜尋關鍵字:為了幫助搜尋引擎更容易搜尋到網站，你可以在這裡填寫相關的搜尋字詞，多組關鍵字以上請使用半形逗號區隔。',
            'offline_text' => '當網站處於離線狀態時顯示給使用者看到的訊息。',
        ],
        'selection' => [
            'active' => [
                '1' => '啟用',
                '0' => '停用',
            ],
        ],
    ],

    'SystemLog' => [
        'id' => 'ID',
        'guard' => '平台',
        'uri' => '操作網址',
        'action' => '動作',
        'guid' => '項目ID',
        'username' => '帳號',
        'ip' => 'IP 位置',
        'note' => '文字說明',
        'result' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'result' => [
                '1' => '成功',
                '0' => '失敗',
            ],
        ],
    ],

    'LoginLog' => [
        'id' => 'ID',
        'guard' => '平台',
        'username' => '帳號',
        'ip' => 'IP 位置',
        'note' => '文字說明',
        'result' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'selection' => [
            'result' => [
                '1' => '成功',
                '0' => '失敗',
            ],
        ],
    ],

];