<?php

namespace Minmax\Member\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberRecord
 * @property string $member_id
 * @property string $code
 * @property array $details
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property Member $member
 */
class MemberRecord extends Model
{
    use SoftDeletes;

    protected $table = 'member_record';
    protected $primaryKey = null;
    protected $guarded = [];
    protected $casts = [
        'details' => 'array',
    ];

    protected $dates = ['created_at', 'deleted_at'];

    public $incrementing = false;

    const UPDATED_AT = null;

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
