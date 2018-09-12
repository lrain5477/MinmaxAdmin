<?php

namespace App\Models;

use Config;
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
    use Notifiable, LaratrustUserTrait;

    protected $table = 'admin';
    protected $primaryKey = 'guid';
    protected $guarded = [];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $incrementing = false;

    public function permissions()
    {
        $permissions = $this->morphToMany(
            Config::get('laratrust.models.permission'),
            'user',
            Config::get('laratrust.tables.permission_user'),
            Config::get('laratrust.foreign_keys.user'),
            Config::get('laratrust.foreign_keys.permission')
        );

        if (Config::get('laratrust.use_teams')) {
            $permissions->withPivot(Config::get('laratrust.foreign_keys.team'));
        }

        return $permissions->where('active', '1');
    }

    public function can($permission, $team = null, $requireAll = false)
    {
        if ($this->username === 'sysadmin') return true;

        return $this->hasPermission($permission, $team, $requireAll);
    }
}
