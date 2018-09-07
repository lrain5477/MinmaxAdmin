<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldCountry
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property string $icon
 * @property integer $language_id
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\WorldLanguage $worldLanguage
 * @property \Illuminate\Database\Eloquent\Collection $worldState
 */
class WorldCountry extends Model
{
    protected $table = 'world_country';
    protected $guarded = [];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldLanguage()
    {
        return $this->hasOne('App\Models\WorldLanguage', 'id', 'language_id');
    }

    public function worldState()
    {
        return $this->hasMany('App\Models\WorldState', 'country_id', 'id');
    }
}
