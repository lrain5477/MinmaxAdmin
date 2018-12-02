<?php

namespace Minmax\Base\Models;

use Laratrust\Models\LaratrustRole;

/**
 * Class Role
 * @property integer $id
 * @property string $guard
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Role extends LaratrustRole
{
    protected $table = 'roles';
    protected $guarded = [];
    protected $casts = [
        'active' => 'boolean'
    ];

    public function getDisplayNameAttribute()
    {
        return langDB($this->getAttributeFromArray('display_name'));
    }

    public function getDescriptionAttribute()
    {
        return langDB($this->getAttributeFromArray('description'));
    }
}