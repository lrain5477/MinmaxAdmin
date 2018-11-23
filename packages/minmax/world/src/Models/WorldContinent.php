<?php

namespace Minmax\World\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldContinent
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|WorldCountry[] $worldCountries
 */
class WorldContinent extends Model
{
    protected $table = 'world_continent';
    protected $guarded = [];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldCountries()
    {
        return $this->hasMany(WorldCountry::class, 'continent_id', 'id');
    }
}
