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

    'accepted' => ':attribute 必须被允许.',
    'active_url' => ':attribute 不是一个有效的网址.',
    'after' => ':attribute 必须是大于 :date 的日期.',
    'after_or_equal' => ':attribute 必须是大于或等于 :date 的日期.',
    'alpha' => ':attribute 只能是英文字母.',
    'alpha_dash' => ':attribute 只能是英文字母、数字或横线.',
    'alpha_num' => ':attribute 只能是英文字母或数字.',
    'array' => ':attribute 必须是一个阵列.',
    'before' => ':attribute 必须是小于 :date 的日期.',
    'before_or_equal' => ':attribute 必须是小于或等于 :date 的日期.',
    'between' => [
        'numeric' => ':attribute 的数值必须介于 :min 至 :max 之间.',
        'file' => ':attribute 的档案大小必须在 :min KB 至 :max KB 之间.',
        'string' => ':attribute 的长度必须是 :min 至 :max 个字元.',
        'array' => ':attribute 阵列必须有 :min 至 :max 个元素.',
    ],
    'boolean' => ':attribute 必须是 true 或 false.',
    'confirmed' => ':attribute 的重复确认并不吻合.',
    'date' => ':attribute 不是一个有效的日期.',
    'date_format' => ':attribute 不符合 :format 的日期格式.',
    'different' => ':attribute 与 :other 必须不相同.',
    'digits' => ':attribute 必须是长度 :digits 的小数.',
    'digits_between' => ':attribute 必须是介于 :min 至 :max 的小数.',
    'dimensions' => ':attribute 包含了无效的图片维度.',
    'distinct' => ':attribute 包含了重复的值.',
    'email' => ':attribute 必须是一个有效的 Email 地址.',
    'exists' => ':attribute 的值无效.',
    'file' => ':attribute 必须是一个档案.',
    'filled' => ':attribute 为必填.',
    'image' => ':attribute 必须是一张图片.',
    'in' => ':attribute 错误',
    'in_array' => ':attribute 不存在于 :other.',
    'integer' => ':attribute 必须是一个整数.',
    'ip' => ':attribute 必须是一个有效的 IP 地址.',
    'ipv4' => ':attribute 必须是一个有效的 IPv4 地址.',
    'ipv6' => ':attribute 必须是一个有效的 IPv6 地址.',
    'json' => ':attribute 必须是合规范的 JSON 字串.',
    'max' => [
        'numeric' => ':attribute 的数值最大为 :max.',
        'file' => ':attribute 的档案大小最大为 :max KB.',
        'string' => ':attribute 的长度最多只能有 :max 个字元.',
        'array' => ':attribute 阵列最多只能有 :max 个元素.',
    ],
    'mimes' => ':attribute 必须是一个 :values 类型的档案.',
    'mimetypes' => ':attribute 必须是一个 :values 类型的档案.',
    'min' => [
        'numeric' => ':attribute 的数值最小为 :min.',
        'file' => ':attribute 的档案大小最小为 :min KB.',
        'string' => ':attribute 的长度最少必须有 :min 个字元.',
        'array' => ':attribute 的阵列最少必须有 :min 个元素.',
    ],
    'not_in' => ':attribute 的值无效.',
    'numeric' => ':attribute 必须是一个数字.',
    'present' => ':attribute 必须存在.',
    'regex' => ':attribute 的格式无效.',
    'required' => ':attribute 为必填.',
    'required_if' => '当 :other 为 :value 时，栏位 :attribute 为必填.',
    'required_unless' => '除 :other 为 :values 外，栏位 :attribute 为必填.',
    'required_with' => '当 :values 存在时，栏位 :attribute 为必填.',
    'required_with_all' => '当 :values 皆存在时，栏位 :attribute 为必填.',
    'required_without' => '当 :values 不存在时，栏位 :attribute 为必填.',
    'required_without_all' => '当 :values 皆不存在时，栏位 :attribute 为必填.',
    'same' => ':attribute 与 :other 必须相同.',
    'size' => [
        'numeric' => ':attribute 的数值必须等于 :size.',
        'file' => ':attribute 的档案大小必须为 :size KB.',
        'string' => ':attribute 的长度必须为 :size 个字元.',
        'array' => ':attribute 阵列必须有 :size 个元素.',
    ],
    'string' => ':attribute 必须为字串.',
    'timezone' => ':attribute 必须是一个有效的时区.',
    'unique' => ':attribute 已经被使用.',
    'uploaded' => ':attribute 上传失败.',
    'url' => ':attribute 不是一个有效的网址.',

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
            'exists' => '您的帐号不存在或所属群组禁用.',
        ],
        'password' => [
            'invalid' => '您输入的密码错误',
        ],
        'ip' => [
            'black' => '您的 IP 为禁止登入黑名单',
            'white' => '您的 IP 不在登入白名单内',
        ],
        'captcha' => [
            'in' => '您的验证码输入错误',
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
