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

    'Member' => [
        'id' => 'ID',
        'username' => '帳號',
        'password' => '密碼',
        'password_confirmation' => '密碼確認',
        'name' => '姓名',
        'email' => 'Email',
        'expired_at' => '過期時間',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'deleted_at' => '刪除時間',
        'role_id' => '群組',
        'hint' => [
            'password' => '若不需更新密碼，請維持此欄位空白',
            'password_confirmation' => '請再次輸入密碼；若不需更新密碼，請維持此欄位空白',
            'expired_at' => '超過所設定的時間後將不可再登入，空白表示無期限',
        ],
    ],

    'MemberDetail' => [
        'member_id' => '會員ID',
        'name' => '會員姓名',
        'contact' => '聯絡資訊',
        'social' => '社群連結',
        'profile' => '個人資訊',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
    ],

    'MemberRecord' => [
        'member_id' => '會員ID',
        'code' => '狀態代碼',
        'details' => [
            'tag' => '狀態標籤',
            'remark' => '系統註記',
            'old' => '更新前欄位',
            'new' => '更新後欄位',
        ],
        'created_at' => '建立時間',
        'deleted_at' => '刪除時間',
    ],

    'MemberAuthentication' => [
        'member_id' => '會員ID',
        'type' => '認證類型',
        'token' => '金鑰',
        'authenticated' => '認證狀態',
        'authenticated_at' => '認證時間',
        'created_at' => '建立時間',
    ],

    'MemberTerm' => [
        'id' => 'ID',
        'title' => '標題',
        'editor' => '條款內容',
        'start_at' => '開始時間',
        'end_at' => '結束時間',
        'active' => '啟用狀態',
        'created_at' => '建立時間',
        'updated_at' => '更新時間',
        'deleted_at' => '刪除時間',
        'hint' => [
            'start_at' => '條款啟用時間。將優先採用時間最接近的條款。',
            'end_at' => '條款結數時間。超過此時間的條款將不再採用。',
        ],
    ],

];