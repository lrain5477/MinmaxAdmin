<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleAdmin
 * @property string $user_id
 * @property integer $role_id
 * @property \App\Models\Admin $admin
 */
class RoleAdmin extends Model
{
    protected $table = 'role_user';
    public $timestamps = false;
    protected $guarded = [];

    public function admin() {
        return $this->hasOne('App\Models\Admin', 'id', 'user_id');
    }
}
