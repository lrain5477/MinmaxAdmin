<?php

namespace Minmax\World\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldState
 * @property integer $id
 * @property integer $country_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property WorldCountry $worldCountry
 * @property \Illuminate\Database\Eloquent\Collection|WorldCounty $worldCounties
 */
class WorldState extends Model
{
    protected $table = 'world_state';
    protected $guarded = [];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldCountry()
    {
        return $this->belongsTo(WorldCountry::class, 'country_id', 'id');
    }

    public function worldCounties()
    {
        return $this->hasMany(WorldCounty::class, 'state_id', 'id');
    }
}
