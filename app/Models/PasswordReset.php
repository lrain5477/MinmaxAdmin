<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 * @property integer $id
 * @property string $guard
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon $expired_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Minmax\Member\Models\Member $member
 */
class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $dates = ['expired_at', 'created_at'];

    protected $guarded = [];

    const UPDATED_AT = null;

    public function member() {
        return $this->hasOne('Minmax\Member\Models\Member', 'email', 'email');
    }
}
