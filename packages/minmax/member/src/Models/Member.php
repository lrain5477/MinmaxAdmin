<?php

namespace Minmax\Member\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * Class Member
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $remember_token
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon $expired_at
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property MemberDetail $memberDetail
 * @property \Illuminate\Database\Eloquent\Collection|\Minmax\Member\Models\MemberRecord[] $memberRecords
 * @property \Illuminate\Database\Eloquent\Collection|\Minmax\Member\Models\MemberAuthentication[] $memberAuthentications
 * @property \Illuminate\Database\Eloquent\Collection|\Minmax\Base\Models\Role[] $roles
 * @property \Illuminate\Database\Eloquent\Collection|\Minmax\Base\Models\Permission[] $permissions
 */
class Member extends Authenticatable
{
    use SoftDeletes, Notifiable, LaratrustUserTrait;

    protected $table = 'member';
    protected $guarded = [];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];

    protected $dates = ['expired_at', 'created_at', 'updated_at', 'deleted_at'];

    public $incrementing = false;

    public function memberDetail()
    {
        return $this->hasOne(MemberDetail::class, 'member_id', 'id');
    }

    public function memberRecords()
    {
        return $this->hasMany(MemberRecord::class, 'member_id', 'id');
    }

    public function memberAuthentications()
    {
        return $this->hasMany(MemberAuthentication::class, 'member_id', 'id');
    }

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
}
