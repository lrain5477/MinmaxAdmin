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

    /**
     * Tries to return all the cached roles of the user.
     * If it can't bring the roles from the cache,
     * it brings them back from the DB.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cachedRoles()
    {
        $cacheKey = 'laratrust_roles_for_user_' . $this->getKey();

        if (! Config::get('laratrust.use_cache')) {
            return $this->roles()->where('active', '1')->get();
        }

        return \Cache::remember($cacheKey, Config::get('cache.ttl', 60), function () {
            return $this->roles()->where('active', '1')->get()->toArray();
        });
    }

    /**
     * Tries to return all the cached permissions of the user
     * and if it can't bring the permissions from the cache,
     * it brings them back from the DB.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cachedPermissions()
    {
        $cacheKey = 'laratrust_permissions_for_user_' . $this->getKey();

        if (! Config::get('laratrust.use_cache')) {
            return $this->permissions()->where('active', '1')->get();
        }

        return \Cache::remember($cacheKey, Config::get('cache.ttl', 60), function () {
            return $this->permissions()->where('active', '1')->get()->toArray();
        });
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param  string|array  $permission Permission string or array of permissions.
     * @param  string|bool  $team      Team name or requiredAll roles.
     * @param  bool  $requireAll All permissions in the array are required.
     * @return bool
     */
    public function can($permission, $team = null, $requireAll = false)
    {
        if ($this->username === 'sysadmin') return true;

        return $this->hasPermission($permission, $team, $requireAll);
    }
}
