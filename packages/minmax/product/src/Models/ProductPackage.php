<?php

namespace Minmax\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductPackage
 * @property string $id
 * @property string $set_sku
 * @property string $item_sku
 * @property integer $amount
 * @property integer $limit
 * @property string $description
 * @property array $price_advice
 * @property array $price_sell
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property ProductSet $productSet
 * @property ProductItem $productItem
 * @property \Illuminate\Database\Eloquent\Collection|ProductMarket[] $productMarkets
 */
class ProductPackage extends Model
{
    protected $table = 'product_package';
    protected $guarded = [];
    protected $dates = ['start_at'];
    protected $casts = [
        'price_advice' => 'array',
        'price_sell' => 'array',
        'active' => 'boolean',
    ];

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getDetailsAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('details')), true);
    }

    public function productSet()
    {
        return $this->hasOne(ProductSet::class, 'sku', 'set_sku');
    }

    public function productItem()
    {
        return $this->hasOne(ProductItem::class, 'sku', 'item_sku');
    }

    public function productMarkets()
    {
        return $this->belongsToMany(ProductMarket::class, 'product_market_package', 'package_id', 'market_id');
    }
}
