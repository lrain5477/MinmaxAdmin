<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property string $icon
 * @property integer $sort
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class WorldLanguage extends Model
{
    protected $table = 'world_language';
    protected $guarded = [];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldCountry()
    {
        return $this->hasMany('App\Models\WorldCountry', 'language_id', 'id');
    }
}
