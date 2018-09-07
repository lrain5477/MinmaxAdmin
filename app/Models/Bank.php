<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bank
 * @property integer $id
 * @property integer $country_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\WorldCountry $worldCountry
 */
class Bank extends Model
{
    protected $table = 'bank';
    protected $guarded = [];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldCountry()
    {
        return $this->belongsTo('App\Models\WorldCountry', 'id', 'country_id');
    }
}
