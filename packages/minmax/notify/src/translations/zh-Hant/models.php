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

    'NotifyEmail' => [
        'id' => 'ID',
        'code' => '通知代碼',
        'title' => '通知標題',
        'notifiable' => '通知用戶',
        'receivers' => '系統收件人',
        'custom_subject' => '用戶信件主旨',
        'custom_preheader' => '用戶信件簡述',
        'custom_editor' => '用戶信件內容',
        'custom_mailable' => '用戶信件服務',
        'admin_subject' => '系統信件主旨',
        'admin_preheader' => '系統信件簡述',
        'admin_editor' => '系統信件內容',
        'admin_mailable' => '系統信件服務',
        'replacements' => '代碼說明',
        'queueable' => '啟用佇列',
        'sort' => '排序',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'hint' => [
            'custom_preheader' => '此內容供收件者未開啟郵件前可看到的文字。',
            'custom_mailable' => '請填入繼承於 Laravel 的 Mail 類別名稱。(含 Namespace 路徑)',
            'admin_preheader' => '此內容供收件者未開啟郵件前可看到的文字。',
            'admin_mailable' => '請填入繼承於 Laravel 的 Mail 類別名稱。(含 Namespace 路徑)',
        ],
    ],

];