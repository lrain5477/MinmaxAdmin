<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMerchant extends Model
{
    protected $table = 'role_user';
    protected $fillable = [
        'role_id', 'user_id',
    ];

    public function merchant() {
        return $this->hasOne('App\Models\Merchant', 'id', 'user_id');
    }
}
