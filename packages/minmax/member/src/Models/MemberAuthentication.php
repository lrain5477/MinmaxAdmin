<?php

namespace Minmax\Member\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberAuthentication
 * @property string $member_id
 * @property string $type
 * @property string $token
 * @property boolean $authenticated
 * @property \Illuminate\Support\Carbon $authenticated_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property Member $member
 */
class MemberAuthentication extends Model
{
    protected $table = 'member_authentication';
    protected $primaryKey = 'token';
    protected $guarded = [];
    protected $casts = [
        'authenticated' => 'boolean',
    ];

    protected $dates = ['authenticated_at', 'created_at'];

    public $incrementing = false;

    const UPDATED_AT = null;

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
