<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemLog
 * @property string $guard
 * @property string $uri
 * @property string $action
 * @property string $guid
 * @property string $username
 * @property string $ip
 * @property string $remark
 * @property integer $result
 * @property \Illuminate\Support\Carbon $created_at
 */
class SystemLog extends Model
{
    protected $table = 'system_log';
    protected $primaryKey = null;
    protected $guarded = [];

    const UPDATED_AT = null;

    public $incrementing = false;
}