<?php

namespace Minmax\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductSet
 * @property string $id
 * @property string $sku
 * @property string $serial
 * @property string $title
 * @property array $pic
 * @property array $details
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property string $brand_id
 * @property integer $rank
 * @property string $spec_group
 * @property array $tags
 * @property array $seo
 * @property boolean $searchable
 * @property boolean $visible
 * @property array $ec_parameters
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property productBrand $productBrand
 * @property \Illuminate\Database\Eloquent\Collection|ProductItem[] $productItems
 * @property \Illuminate\Database\Eloquent\Collection|ProductPackage[] $productPackages
 * @property \Illuminate\Database\Eloquent\Collection|ProductCategory[] $productCategories
 */
class ProductSet extends Model
{
    protected $table = 'product_set';
    protected $guarded = [];
    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at'];
    protected $casts = [
        'pic' => 'array',
        'searchable' => 'boolean',
        'visible' => 'boolean',
        'active' => 'boolean',
        'ec_parameters' => 'array',
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

    public function getSeoAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('seo')), true);
    }

    public  function productBrand()
    {
        return $this->hasOne(ProductBrand::class, 'id', 'brand_id');
    }

    public function productItems()
    {
        return $this->belongsToMany(ProductItem::class, 'product_package', 'set_sku', 'item_sku', 'sku', 'sku');
    }

    public function productPackages()
    {
        return $this->hasMany(ProductPackage::class, 'set_sku', 'sku');
    }

    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category_set', 'set_id', 'category_id');
    }
}
