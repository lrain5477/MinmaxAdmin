<?php

namespace Minmax\Base\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * Class Admin
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $remember_token
 * @property string $name
 * @property string $email
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 */
class Admin extends Authenticatable
{
    use Notifiable, LaratrustUserTrait;

    protected $table = 'admin';
    protected $guarded = [];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'active' => 'boolean',
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

        if (! config('laratrust.use_cache')) {
            return $this->roles()->where('active', true)->get();
        }

        return \Cache::remember($cacheKey, config('cache.ttl', 60), function () {
            return $this->roles()->where('active', true)->get()->toArray();
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

        if (! config('laratrust.use_cache')) {
            return $this->permissions()->where('active', true)->get();
        }

        return \Cache::remember($cacheKey, config('cache.ttl', 60), function () {
            return $this->permissions()->where('active', true)->get()->toArray();
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
