<?php

namespace Minmax\World\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldCity
 * @property integer $id
 * @property string $county_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property array $options
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property WorldCounty $worldCounty
 */
class WorldCity extends Model
{
    protected $table = 'world_city';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
    ];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldCounty()
    {
        return $this->belongsTo(WorldCounty::class, 'county_id', 'id');
    }
}
