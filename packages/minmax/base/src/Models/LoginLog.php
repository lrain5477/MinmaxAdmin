<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginLog
 * @property string $guard
 * @property string $username
 * @property string $ip
 * @property string $remark
 * @property boolean $result
 * @property \Illuminate\Support\Carbon $created_at
 */
class LoginLog extends Model
{
    protected $table = 'login_log';
    protected $primaryKey = null;
    protected $guarded = [];
    protected $casts = [
        'result' => 'boolean',
    ];

    const UPDATED_AT = null;
}
