<?php

namespace Minmax\World\Models;

use Illuminate\Database\Eloquent\Model;
use Minmax\Base\Models\WorldLanguage;

/**
 * Class WorldCountry
 * @property integer $id
 * @property integer $continent_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property string $icon
 * @property integer $language_id
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property WorldContinent $worldContinent
 * @property \Illuminate\Database\Eloquent\Collection|WorldState[] $worldStates
 * @property WorldLanguage $worldLanguage
 */
class WorldCountry extends Model
{
    protected $table = 'world_country';
    protected $guarded = [];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldContinent()
    {
        return $this->belongsTo(WorldContinent::class, 'continent_id', 'id');
    }

    public function worldStates()
    {
        return $this->hasMany(WorldState::class, 'country_id', 'id');
    }

    public function worldLanguage()
    {
        return $this->hasOne(WorldLanguage::class, 'id', 'language_id');
    }
}
