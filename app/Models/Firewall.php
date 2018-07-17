<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Firewall
 * @property integer $id
 * @property string $guid
 * @property string $guard
 * @property string $ip
 * @property integer $rule
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Firewall extends Model
{
    protected $table = 'firewall';
    protected $guarded = [];

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