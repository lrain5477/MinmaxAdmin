<?php

namespace Minmax\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MemberTerm
 * @property string $id
 * @property string $title
 * @property string $editor
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class MemberTerm extends Model
{
    use SoftDeletes;

    protected $table = 'member_term';
    protected $guarded = [];
    protected $casts = [
        'active' => 'boolean',
    ];

    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at', 'deleted_at'];

    public $incrementing = false;

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getEditorAttribute()
    {
        return langDB($this->getAttributeFromArray('editor'));
    }
}
