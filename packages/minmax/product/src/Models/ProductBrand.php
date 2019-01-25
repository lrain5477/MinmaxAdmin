<?php

namespace Minmax\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductBrand
 * @property string $id
 * @property string $title
 * @property array $pic
 * @property array $details
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|ProductSet[] $productSets
 */
class ProductBrand extends Model
{
    protected $table = 'product_brand';
    protected $guarded = [];
    protected $casts = [
        'pic' => 'array',
        'active' => 'boolean',
    ];

    public $incrementing = false;

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getDetailsAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('details')), true);
    }

    public function productSets()
    {
        return $this->hasMany(ProductSet::class, 'brand_id', 'id');
    }
}
