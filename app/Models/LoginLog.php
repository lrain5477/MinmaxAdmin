<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_log';
    protected $fillable = [
        'guard', 'username', 'ip', 'note', 'result',
    ];
}