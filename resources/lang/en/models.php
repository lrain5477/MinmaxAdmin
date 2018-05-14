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
        'username' => 'Username',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'name' => 'Name',
        'allow_ip' => 'IP Whitelist',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
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
        'role_id' => 'Role',
        'username' => 'Username',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'name' => 'Name',
        'email' => 'Email',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
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
        'title' => 'Class Name',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'AdminMenuItem' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => 'Language',
        'title' => 'Title',
        'uri' => 'Uri',
        'model' => 'Model Name',
        'class' => 'Class',
        'parent' => 'Parent Menu',
        'link' => 'Link',
        'icon' => 'Icon Class',
        'filter' => 'Data Filter (where)',
        'keeps' => 'Keep GUID',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
        'hint' => [
            'icon' => '僅 (根列表) 使用，請參考連結選擇您所需要的圖示 <a target="_blank" href="/admin/css/fonts/icon/demo.html">圖示列表</a>',
        ],
    ],

    'MerchantMenuClass' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'title' => 'Class Name',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'MerchantMenuItem' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => 'Language',
        'title' => 'Title',
        'uri' => 'Uri',
        'model' => 'Model Name',
        'class' => 'Class',
        'parent' => 'Parent Menu',
        'link' => 'Link',
        'icon' => 'Icon Class',
        'filter' => 'Data Filter (where)',
        'keeps' => 'Keep GUID',
        'sort' => 'Sort',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
        'hint' => [
            'icon' => '僅 (根列表) 使用，請參考連結選擇您所需要的圖示 <a target="_blank" href="/admin/css/fonts/icon/demo.html">圖示列表</a>',
        ],
    ],

    'Role' => [
        'id' => 'ID',
        'guard' => 'Platform',
        'name' => 'Unique Code',
        'display_name' => 'Role Name',
        'description' => 'Description',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
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
        'guard' => 'Platform',
        'ip' => 'IP Address',
        'rule' => 'Rule',
        'active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'rule' => [
                '1' => 'Allow',
                '0' => 'Deny',
            ],
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'WebData' => [
        'id' => 'ID',
        'guid' => 'GUID',
        'lang' => 'Language',
        'website_name' => 'Site Name',
        'system_email' => 'System Email',
        'system_url' => 'System URL',
        'company_name' => 'Company Name',
        'company_name_en' => 'Company Name (EN)',
        'company_id' => 'Company ID',
        'phone' => 'Phone',
        'fax' => 'Fax',
        'email' => 'Service Email',
        'address' => 'Address',
        'map_lng' => 'Map Lng.',
        'map_lat' => 'Map Lat.',
        'map_url' => 'Map Link',
        'link_facebook' => 'Facebook',
        'link_instagram' => 'Instagram',
        'link_twitter' => 'Twitter',
        'link_gplus' => 'Google+',
        'link_youtube' => 'Youtube',
        'seo_description' => 'SEO Description',
        'seo_keywords' => 'SEO Keywords',
        'google_analytics' => 'Google Analytics',
        'active' => 'Active',
        'offline_text' => 'Offline Text',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'hint' => [
            'seo_description' => '(Metadata Description) 利用簡短的說明讓人清楚的了解網站的主要內容、簡介方向等，搜尋引擎將會幫我們適當的顯示在介紹頁面上。',
            'seo_keywords' => '(Metadata Keywords) 搜尋關鍵字:為了幫助搜尋引擎更容易搜尋到網站，你可以在這裡填寫相關的搜尋字詞，多組關鍵字以上請使用半形逗號區隔。',
            'offline_text' => '當網站處於離線狀態時顯示給使用者看到的訊息。',
        ],
        'selection' => [
            'active' => [
                '1' => 'On',
                '0' => 'Off',
            ],
        ],
    ],

    'SystemLog' => [
        'id' => 'ID',
        'guard' => 'Platform',
        'uri' => 'URI',
        'action' => 'Action',
        'guid' => 'Action ID',
        'username' => 'Username',
        'ip' => 'IP',
        'note' => 'Note',
        'result' => 'Result',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'result' => [
                '1' => 'Success',
                '0' => 'Failure',
            ],
        ],
    ],

    'LoginLog' => [
        'id' => 'ID',
        'guard' => 'Platform',
        'username' => 'Username',
        'ip' => 'IP',
        'note' => 'Note',
        'result' => 'Result',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'selection' => [
            'result' => [
                '1' => 'Success',
                '0' => 'Failure',
            ],
        ],
    ],

];