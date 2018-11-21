<?php

namespace Minmax\Base\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Administrator
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $remember_token
 * @property string $name
 * @property string $allow_ip
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Administrator extends Authenticatable
{
    use Notifiable;

    protected $table = 'administrator';
    protected $guarded = [];
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $incrementing = false;
}
