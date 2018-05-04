<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAdmin extends Model
{
    protected $table = 'role_user';
    public $timestamps = false;
    protected $fillable = [
        'role_id', 'user_id',
    ];

    public function admin() {
        return $this->hasOne('App\Models\Admin', 'id', 'user_id');
    }
}
