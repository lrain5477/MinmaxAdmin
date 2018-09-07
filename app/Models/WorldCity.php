<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldCity
 * @property integer $id
 * @property string $state_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\WorldState $worldState
 */
class WorldCity extends Model
{
    protected $table = 'world_city';
    protected $guarded = [];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldState()
    {
        return $this->hasOne('App\Models\WorldState', 'id', 'state_id');
    }
}
