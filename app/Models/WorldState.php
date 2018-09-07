<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldState
 * @property integer $id
 * @property integer $country_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\WorldCountry $worldCountry
 * @property \Illuminate\Database\Eloquent\Collection $worldCity
 */
class WorldState extends Model
{
    protected $table = 'world_state';
    protected $guarded = [];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldCountry()
    {
        return $this->hasOne('App\Models\WorldCountry', 'id', 'country_id');
    }

    public function worldCity()
    {
        return $this->hasMany('App\Models\WorldCity', 'state_id', 'id');
    }
}
