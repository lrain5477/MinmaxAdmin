<?php

namespace Minmax\Ad\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Advertising
 * @property string $id
 * @property integer $category_id
 * @property string $title
 * @property string $target
 * @property string $link
 * @property array $details
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property AdvertisingCategory $advertisingCategory
 */
class Advertising extends Model
{
    protected $table = 'advertising';
    protected $guarded = [];
    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public $incrementing = false;

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getLinkAttribute()
    {
        return langDB($this->getAttributeFromArray('link'));
    }

    public function getDetailsAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('details')), true);
    }

    public function advertisingCategory()
    {
        return $this->belongsTo(AdvertisingCategory::class, 'category_id', 'id');
    }
}
