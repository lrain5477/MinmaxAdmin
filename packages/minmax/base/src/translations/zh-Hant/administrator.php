<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administrator Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the system text in admin page.
    |
    */

    'page_not_found' => [
        'message' => '對不起，您所請求的頁面不存在。',
    ],

    'header' => [
        'menu' => '選單',
        'profile' => '個人資料',
        'language' => '語系',
        'account' => '帳戶',
        'login' => '登入',
        'logout' => '登出',
    ],

    'breadcrumbs' => [
        'home' => '系統首頁',
    ],

    'sidebar' => [
        'home' => '系統首頁',
    ],

    'login' => [
        'title' => '總後臺管理系統',
        'forget' => '忘記密碼?',
        'username' => '您的帳號',
        'email' => '您的信箱',
        'password' => '您的密碼',
        'captcha' => '驗證號碼',
        'remember' => '記住我',
        'login_submit' => '登入系統',
        'forget_submit' => '送出',
        'back_button' => '返回',
        'info' => [
            'topic' => 'Welcome!',
            'message' => '歡迎您使用:site，<br>若您於登入上有任何問題，<br>請來信與我們聯絡，我們將會盡快為您處理!<br>祝您使用愉快與方便!',
            'forget' => '輸入您的 Email 系統將寄發密碼至您的註冊信箱.',
        ],
    ],

    'dashboard' => [
        'source_from' => '流量來源',
        'visits' => '訪問',
        'online_users' => '線上使用者',
        'new_session' => '新工作階段',
        'session_page' => '單次頁數',
        'stay_time' => '停留時間',
        'exit_rate' => '跳出率',
        'browser_usage' => '瀏覽器使用',
        'source_country' => '流量地區分布',
        'today_visitors' => '今日參觀量',
        'service_message' => '客服信函',
        'recently_message' => '近期聯絡表單',
        'empty_message' => '沒有聯絡表單',
        'view_all' => '瀏覽全部',
        'keywords' => '熱門關鍵字',
        'keyword' => '關鍵字',
        'keyword_count' => '次數',
        'medium' => [
            'direct' => '直接',
            'organic' => '搜尋',
            'referral' => '推薦',
            'json_direct' => 'Direct 直接',
            'json_organic' => 'Organic 搜尋',
            'json_referral' => 'Referral 推薦',
        ],
    ],

    'grid' => [
        'title' => [
            'action' => '動作'
        ],
        'actions' => [
            'view' => '瀏覽',
            'edit' => '編輯',
            'delete' => '刪除',
            'children' => '子項目',
        ],
        'selection' => [
            'all' => '全部',
        ],
        'back' => '返回',
        'batch' => '批次',
        'root' => '根列表',
        'next_layer' => '下層列表',
        'click_to_switch' => '點選變更狀態',
        'search' => '搜尋',
        'filter' => '篩選',
    ],

    'form' => [
        'view' => '瀏覽',
        'create' => '新增',
        'edit' => '編輯',
        'language' => '語系',
        'import' => '匯入',
        'export' => '匯出',
        'back_list' => '返回列表',
        'record' => '系統紀錄',
        'note' => '說明敘述',
        'select_default_title' => '請選擇項目',
        'select_nothing_title' => '不選擇',
        'password_build_auto' => '預設密碼為 123456，由系統自動設定',
        'select_all' => '選擇全部',
        'select_clear' => '清除選取',
        'fieldSet' => [
            'default' => '主要設定',
            'information' => '資訊設定',
            'media' => '多媒體設定',
            'advanced' => '進階選項',
            'permission' => '權限設定',
            'seo' => '搜尋引擎優化',
            'system_record' => '系統紀錄',
        ],
        'button' => [
            'send' => '送出',
            'reset' => '重新設定',
            'import' => '匯入',
            'export' => '匯出',
            'media_image' => '媒體庫',
            'media_file' => '選擇檔案',
        ],
        'file' => [
            'default_text' => '檔案上傳',
            'browser' => '瀏覽',
            'remove_file' => '移除已上傳的檔案',
            'limit_title' => '超過選擇上限',
            'limit_text' => '您最多只能選擇 :limit 個檔案',
        ],
        'image' => [
            'advance_tab_1' => '圖片資訊',
            'advance_panel_fieldSet_base' => '基本設定',
        ],
        'message' => [
            'create_success' => '您新增的資料儲存成功。',
            'create_error' => '您的新增資料操作失敗。',
            'edit_success' => '您編輯的資料儲存成功。',
            'edit_error' => '您編輯的資料儲存失敗。',
            'delete_success' => '您選擇的資料已經刪除成功。',
            'delete_error' => '您選擇的資料無法刪除，請再次確認。',
            'delete_error_account_self' => '您無法刪除自己的帳號，請再次確認。',
            'import_success' => '您的資料已經匯入成功。',
            'import_error' => '您的資料匯入失敗，請再次確認。',
            'import_error_extension' => '您的來源檔案不符合要求格式，請再次確認。',
            'export_error' => '您的資料匯出失敗，請再次嘗試。',
        ],
        'elfinder' => [
            'limit_title' => '已達到選擇上限',
            'limit_text' => '您最多只能選擇 :limit 個檔案',
            'limit_confirm_button' => '確認',
            'remove_title' => '是否確認刪除',
            'remove_text' => '您將刪除此檔案',
            'remove_cancel_button' => '取消',
            'remove_confirm_button' => '確認',
            'remove_success_title' => '刪除完成!',
            'remove_success_text' => '您的檔案已刪除!',
        ],
    ],

];