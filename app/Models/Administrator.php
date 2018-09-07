<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Administrator
 * @property string $guid
 * @property string $username
 * @property string $password
 * @property string $remember_token
 * @property string $name
 * @property string $allow_ip
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Administrator extends Authenticatable
{
    use Notifiable;

    protected $table = 'administrator';
    protected $primaryKey = 'guid';
    protected $guarded = [];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $incrementing = false;
}
