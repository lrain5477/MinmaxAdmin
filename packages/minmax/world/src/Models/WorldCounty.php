<?php

namespace Minmax\World\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldCounty
 * @property integer $id
 * @property integer $state_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property WorldState $worldState
 * @property \Illuminate\Database\Eloquent\Collection|WorldCity[] $worldCities
 */
class WorldCounty extends Model
{
    protected $table = 'world_county';
    protected $guarded = [];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldState()
    {
        return $this->belongsTo(WorldState::class, 'state_id', 'id');
    }

    public function worldCities()
    {
        return $this->hasMany(WorldCity::class, 'county_id', 'id');
    }
}
