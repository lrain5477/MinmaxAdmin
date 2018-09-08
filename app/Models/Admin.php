<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * Class Admin
 * @property string $guid
 * @property string $username
 * @property string $password
 * @property string $remember_token
 * @property string $name
 * @property string $email
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Admin extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'guid';
    protected $guarded = [];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $incrementing = false;
}
