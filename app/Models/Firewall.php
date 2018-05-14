<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firewall extends Model
{
    protected $table = 'firewall';
    protected $fillable = [
        'guid', 'guard', 'ip', 'rule', 'active',
    ];

    public static function getIndexKey()
    {
        return 'guid';
    }

    /**
     * Return if this model's table with column `lang` and need to use.
     * @return bool
     */
    public static function isMultiLanguage()
    {
        return false;
    }

    public static function rules()
    {
        return [
            'guard' => 'required|in:admin,merchant',
            'ip' => 'required|ip',
            'rule' => 'required|in:1,0',
            'active' => 'required|in:1,0',
        ];
    }
}