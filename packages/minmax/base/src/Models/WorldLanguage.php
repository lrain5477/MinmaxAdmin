<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $native
 * @property array $options
 * @property integer $sort
 * @property boolean $active_admin
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class WorldLanguage extends Model
{
    protected $table = 'world_language';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
    ];

    public function getNativeAttribute()
    {
        return langDB($this->getAttributeFromArray('native'));
    }

    public function worldCountry()
    {
        return $this->hasMany('App\Models\WorldCountry', 'language_id', 'id');
    }
}
