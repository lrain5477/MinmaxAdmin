<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'm_password_reset';
    protected $fillable = [
        'email', 'token', 'expired_at'
    ];

    public function setUpdatedAtAttribute($value) {}

    public function member() {
        return $this->hasOne('App\Models\Member', 'email', 'email');
    }
}
