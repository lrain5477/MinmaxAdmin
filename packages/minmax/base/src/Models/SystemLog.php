<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemLog
 * @property string $guard
 * @property string $uri
 * @property string $action
 * @property string $id
 * @property string $username
 * @property string $ip
 * @property string $remark
 * @property boolean $result
 * @property \Illuminate\Support\Carbon $created_at
 */
class SystemLog extends Model
{
    protected $table = 'system_log';
    protected $primaryKey = null;
    protected $guarded = [];
    protected $casts = [
        'result' => 'boolean',
    ];

    const UPDATED_AT = null;
}
