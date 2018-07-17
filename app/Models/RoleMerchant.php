<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleMerchant
 * @property string $user_id
 * @property integer $role_id
 * @property \App\Models\Merchant $merchant
 */
class RoleMerchant extends Model
{
    protected $table = 'role_user';
    public $timestamps = false;
    protected $fillable = [
        'role_id', 'user_id',
    ];

    public function merchant() {
        return $this->hasOne('App\Models\Merchant', 'id', 'user_id');
    }
}
