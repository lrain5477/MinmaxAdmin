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

    'form' => [
        'account' => '帳號設定',
        'profile' => '個人資料',
        'authentication' => '會員認證',
        'record' => '異動紀錄',
        'table' => [
            'authentication' => [
                'type' => '認證類型',
                'token' => '金鑰',
                'authenticated' => '認證狀態',
                'actions' => '動作',
                'do-auth' => '手動認證',
                'do-remove' => '刪除',
                'do-add' => '新增',
            ],
            'record' => [
                'created_at' => '時間',
                'code' => '代碼',
                'tag' => '狀態',
                'remark' => '系統註記',
            ],
        ],
        'message' => [
            'authentication' => [
                'edit_success' => '會員驗證狀態更新成功。',
                'edit_error' => '會員驗證狀態更新失敗。',
                'delete_success' => '會員驗證資料刪除成功。',
                'delete_error' => '會員驗證資料刪除失敗。',
            ],
        ],
    ],

];