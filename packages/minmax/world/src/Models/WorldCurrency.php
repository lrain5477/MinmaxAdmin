<?php

namespace Minmax\World\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldCurrency
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property array $options
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\Minmax\Base\Models\WorldLanguage[] $worldLanguage
 */
class WorldCurrency extends Model
{
    protected $table = 'world_currency';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
    ];

    public function getNameAttribute()
    {
        return langDB($this->getAttributeFromArray('name'));
    }

    public function worldLanguage()
    {
        return $this->hasMany('Minmax\Base\Models\WorldLanguage', 'currency_id', 'id');
    }
}
