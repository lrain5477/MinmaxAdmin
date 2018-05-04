<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firewall extends Model
{
    protected $table = 'firewall';
    protected $fillable = [
        'guid', 'guard', 'ip', 'rule', 'active',
    ];

    public static function getIndexKey() {
        return 'guid';
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