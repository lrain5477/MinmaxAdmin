<?php

namespace Minmax\Member\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberDetail
 * @property string $member_id
 * @property array $name
 * @property array $contact
 * @property array $social
 * @property array $profile
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property Member $member
 */
class MemberDetail extends Model
{
    protected $table = 'member_detail';
    protected $primaryKey = 'member_id';
    protected $guarded = [];
    protected $casts = [
        'name' => 'array',
        'contact' => 'array',
        'social' => 'array',
        'profile' => 'array',
    ];

    public $incrementing = false;

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
