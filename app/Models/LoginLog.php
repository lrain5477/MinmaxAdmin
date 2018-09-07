<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginLog
 * @property integer $id
 * @property string $guard
 * @property string $username
 * @property string $ip
 * @property string $note
 * @property integer $result
 * @property \Illuminate\Support\Carbon $created_at
 */
class LoginLog extends Model
{
    protected $table = 'login_log';
    protected $primaryKey = null;
    protected $guarded = [];

    const UPDATED_AT = null;

    public $incrementing = false;
}