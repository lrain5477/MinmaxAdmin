<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute 必須被允許.',
    'active_url'           => ':attribute 不是一個有效的網址.',
    'after'                => ':attribute 必須是大於 :date 的日期.',
    'after_or_equal'       => ':attribute 必須是大於或等於 :date 的日期.',
    'alpha'                => ':attribute 只能是英文字母.',
    'alpha_dash'           => ':attribute 只能是英文字母、數字、橫線或底線.',
    'alpha_num'            => ':attribute 只能是英文字母或數字.',
    'array'                => ':attribute 必須是一個陣列.',
    'before'               => ':attribute 必須是小於 :date 的日期.',
    'before_or_equal'      => ':attribute 必須是小於或等於 :date 的日期.',
    'between'              => [
        'numeric' => ':attribute 的數值必須介於 :min 至 :max 之間.',
        'file'    => ':attribute 的檔案大小必須在 :min KB 至 :max KB 之間.',
        'string'  => ':attribute 的長度必須是 :min 至 :max 個字元.',
        'array'   => ':attribute 陣列必須有 :min 至 :max 個元素.',
    ],
    'boolean'              => ':attribute 必須是 true 或 false.',
    'confirmed'            => ':attribute 的重複確認並不吻合.',
    'date'                 => ':attribute 不是一個有效的日期.',
    'date_format'          => ':attribute 不符合 :format 的日期格式.',
    'different'            => ':attribute 與 :other 必須不相同.',
    'digits'               => ':attribute 必須是長度 :digits 的小數.',
    'digits_between'       => ':attribute 必須是介於 :min 至 :max 的小數.',
    'dimensions'           => ':attribute 包含了無效的圖片維度.',
    'distinct'             => ':attribute 包含了重複的值.',
    'email'                => ':attribute 必須是一個有效的 Email 地址.',
    'exists'               => ':attribute 的值無效.',
    'file'                 => ':attribute 必須是一個檔案.',
    'filled'               => ':attribute 為必填.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => ':attribute 必須是一張圖片.',
    'in'                   => ':attribute 錯誤',
    'in_array'             => ':attribute 不存在於 :other.',
    'integer'              => ':attribute 必須是一個整數.',
    'ip'                   => ':attribute 必須是一個有效的 IP 地址.',
    'ipv4'                 => ':attribute 必須是一個有效的 IPv4 地址.',
    'ipv6'                 => ':attribute 必須是一個有效的 IPv6 地址.',
    'json'                 => ':attribute 必須是合規範的 JSON 字串.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => ':attribute 的數值最大為 :max.',
        'file'    => ':attribute 的檔案大小最大為 :max KB.',
        'string'  => ':attribute 的長度最多只能有 :max 個字元.',
        'array'   => ':attribute 陣列最多只能有 :max 個元素.',
    ],
    'mimes'                => ':attribute 必須是一個 :values 類型的檔案.',
    'mimetypes'            => ':attribute 必須是一個 :values 類型的檔案.',
    'min'                  => [
        'numeric' => ':attribute 的數值最小為 :min.',
        'file'    => ':attribute 的檔案大小最小為 :min KB.',
        'string'  => ':attribute 的長度最少必須有 :min 個字元.',
        'array'   => ':attribute 的陣列最少必須有 :min 個元素.',
    ],
    'not_in'               => ':attribute 的值無效.',
    'not_regex'            => ':attribute 的格式無效.',
    'numeric'              => ':attribute 必須是一個數字.',
    'present'              => ':attribute 必須存在.',
    'regex'                => ':attribute 的格式無效.',
    'required'             => ':attribute 為必填.',
    'required_if'          => '當 :other 為 :value 時，欄位 :attribute 為必填.',
    'required_unless'      => '除 :other 為 :values 外，欄位 :attribute 為必填.',
    'required_with'        => '當 :values 存在時，欄位 :attribute 為必填.',
    'required_with_all'    => '當 :values 皆存在時，欄位 :attribute 為必填.',
    'required_without'     => '當 :values 不存在時，欄位 :attribute 為必填.',
    'required_without_all' => '當 :values 皆不存在時，欄位 :attribute 為必填.',
    'same'                 => ':attribute 與 :other 必須相同.',
    'size'                 => [
        'numeric' => ':attribute 的數值必須等於 :size.',
        'file'    => ':attribute 的檔案大小必須為 :size KB.',
        'string'  => ':attribute 的長度必須為 :size 個字元.',
        'array'   => ':attribute 陣列必須有 :size 個元素.',
    ],
    'string'               => ':attribute 必須為字串.',
    'timezone'             => ':attribute 必須是一個有效的時區.',
    'unique'               => ':attribute 已經被使用.',
    'uploaded'             => ':attribute 上傳失敗.',
    'url'                  => ':attribute 不是一個有效的網址.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'username' => [
            'exists' => '您的帳號不存在或所屬群組禁用.',
        ],
        'password' => [
            'invalid' => '您輸入的密碼錯誤',
        ],
        'ip' => [
            'black' => '您的 IP 為禁止登入黑名單',
            'white' => '您的 IP 不在登入白名單內',
        ],
        'captcha' => [
            'in' => '您的驗證碼輸入錯誤',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
