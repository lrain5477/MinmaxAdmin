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
        'guid' => 'ID',
        'username' => '帳號',
        'password' => '密碼',
        'password_confirmation' => '密碼確認',
        'name' => '姓名',
        'allow_ip' => 'IP白名單',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'allow_ip' => '請斷行設定可登入來源IP位置，空白表示可自任何地方登入',
            'password' => '若不需更新密碼，請維持此欄位空白',
            'password_confirmation' => '請再次輸入密碼；若不需更新密碼，請維持此欄位空白',
        ],
    ],

    'Admin' => [
        'guid' => 'ID',
        'username' => '帳號',
        'password' => '密碼',
        'password_confirmation' => '密碼確認',
        'name' => '姓名',
        'email' => 'Email',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'role_id' => '群組',
        'hint' => [
            'password' => '若不需更新密碼，請維持此欄位空白',
            'password_confirmation' => '請再次輸入密碼；若不需更新密碼，請維持此欄位空白',
        ],
    ],

    'AdminMenu' => [
        'guid' => 'ID',
        'title' => '選單名稱',
        'uri' => 'Uri',
        'controller' => 'Controller 名稱',
        'model' => 'Model 名稱',
        'class' => '類別',
        'parent_id' => '上層目錄',
        'link' => '項目連結',
        'icon' => '圖示 Class',
        'permission_key' => '權限綁定代碼',
        'filter' => '資料過濾 (where)',
        'keeps' => '不可刪除 GUID',
        'sort' => '排序',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'icon' => '僅 (根列表) 使用，請參考連結選擇您所需要的圖示 <a target="_blank" href="/static/admin/css/fonts/icon/demo.html">圖示列表</a>',
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
    ],

    'Permission' => [
        'id' => 'ID',
        'guard' => '平台',
        'group' => '群組',
        'name' => '代碼',
        'label' => '標籤',
        'display_name' => '權限名稱',
        'description' => '敘述',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'WorldLanguage' => [
        'id' => 'ID',
        'code' => '語系代碼',
        'name' => '語系名稱',
        'native' => '顯示文字',
        'options' => '語系設定',
        'currency_id' => '貨幣',
        'sort' => '排序',
        'active_admin' => '後臺啟用',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'Firewall' => [
        'id' => 'ID',
        'guard' => '平台',
        'ip' => 'IP 位址',
        'rule' => '規則',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'WebData' => [
        'guid' => 'ID',
        'guard' => '平台',
        'website_name' => '網站名稱',
        'system_email' => '系統信箱',
        'system_url' => '網站網址',
        'system_logo' => '網站Logo',
        'company' => [
            'name' => '公司名稱',
            'name_en' => '公司英文名稱',
            'id' => '統一編號'
        ],
        'contact' => [
            'phone' => '客服電話',
            'fax' => '傳真號碼',
            'email' => '客服信箱',
            'address' => '公司地址',
            'map' => '地址連結',
            'lng' => '地圖經度',
            'lat' => '地圖緯度',
        ],
        'social' => [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'gplus' => 'Google+',
            'youtube' => 'Youtube',
        ],
        'seo' => [
            'meta_description' => 'SEO 網站描述',
            'meta_keywords' => 'SEO 關鍵字',
        ],
        'options' => [
            'head' => '標頭內容',
            'body' => '頁首內容',
            'foot' => '頁尾內容',
        ],
        'active' => '網站狀態',
        'offline_text' => '網站離線訊息',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'system_logo' => '建議尺寸：190px * 30px。圖片類型：png。',
            'seo' => [
                'meta_description' => '(Metadata Description) 利用簡短的說明讓人清楚的了解網站的主要內容、簡介方向等，搜尋引擎將會幫我們適當的顯示在介紹頁面上。',
                'meta_keywords' => '(Metadata Keywords) 為了幫助搜尋引擎更容易搜尋到網站，你可以在這裡填寫相關的搜尋字詞，多組關鍵字以上請使用半形逗號區隔。',
            ],
            'options' => [
                'head' => '此處內容將會放置於網頁標頭 (&lt;/head&gt;之前)，您可以於此處貼上 Google Analytics 或其他追蹤程式碼。',
                'body' => '此處內容將會出現於網頁最上方 (&lt;body&gt;之後)，若您不清楚網頁結構，請勿修改此處內容。',
                'foot' => '此處內容將會出現於網頁最下方 (&lt;/body&gt;之前)，若您不清楚網頁結構，請勿修改此處內容。',
            ],
            'offline_text' => '當網站處於離線狀態時顯示給使用者看到的訊息。',
        ],
    ],

    'EditorTemplate' => [
        'id' => 'ID',
        'guard' => '平台',
        'category' => '使用類別',
        'title' => '名稱',
        'description' => '敘述',
        'editor' => 'HTML內容',
        'sort' => '排序',
        'active' => '狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
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
    ],

    'SystemParameterGroup' => [
        'id' => 'ID',
        'code' => '群組代碼',
        'title' => '群組名稱',
        'options' => '群組設定',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'SystemParameterItem' => [
        'id' => 'ID',
        'group_id' => '參數群組',
        'value' => '參數數值',
        'label' => '參數名稱',
        'options' => '參數設定',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'SiteParameterGroup' => [
        'id' => 'ID',
        'code' => '群組代碼',
        'title' => '群組名稱',
        'options' => '群組設定',
        'active' => '啟用狀態',
        'editable' => '可否編輯',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'SiteParameterItem' => [
        'id' => 'ID',
        'group_id' => '參數群組',
        'value' => '參數數值',
        'label' => '參數名稱',
        'options' => '參數設定',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'NewsletterSchedule' => [
        'id' => 'ID',
        'title' => '電子報主題',
        'subject' => '信件主旨',
        'content' => '信件內容',
        'schedule_at' => '排程時間',
        'groups' => '發送類別',
        'objects' => '發送目標',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'NewsletterTemplate' => [
        'id' => 'ID',
        'title' => '電子報主題',
        'subject' => '信件主旨',
        'content' => '信件內容',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'NewsletterGroup' => [
        'id' => 'ID',
        'title' => '類別名稱',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

];