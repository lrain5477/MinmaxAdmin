<?php

namespace Minmax\Ad\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdvertisingCategory
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $remark
 * @property string $ad_type
 * @property array $options
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|Advertising[] $advertising
 * @property array $type
 */
class AdvertisingCategory extends Model
{
    protected $table = 'advertising_category';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
    ];

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getRemarkAttribute()
    {
        return langDB($this->getAttributeFromArray('remark'));
    }

    public function getTypeAttribute()
    {
        return systemParam("ad_type.{$this->ad_type}");
    }

    public function advertising()
    {
        return $this->hasMany(Advertising::class, 'category_id', 'id');
    }
}
