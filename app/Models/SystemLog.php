<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_log';
    protected $fillable = [
        'guard', 'uri', 'action', 'guid', 'username', 'ip', 'note', 'result',
    ];

    public static function getIndexKey() {
        return 'id';
    }
}