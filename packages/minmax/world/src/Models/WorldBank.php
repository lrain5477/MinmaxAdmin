<?php

namespace Minmax\World\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldBank
 * @property integer $id
 * @property integer $country_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Minmax\World\Models\WorldCountry $worldCountry
 */
class WorldBank extends Model
{
    protected $table = 'world_bank';
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
        return $this->hasOne(WorldCountry::class, 'id', 'country_id');
    }
}
