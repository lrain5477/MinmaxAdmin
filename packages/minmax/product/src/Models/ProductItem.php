<?php

namespace Minmax\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductItem
 * @property string $id
 * @property string $sku
 * @property string $serial
 * @property string $title
 * @property array $pic
 * @property array $details
 * @property array $cost
 * @property array $price
 * @property boolean $qty_enable
 * @property integer $qty_safety
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|ProductQuantity[] $productQuantities
 * @property \Illuminate\Database\Eloquent\Collection|ProductPackage[] $productPackages
 * @property \Illuminate\Database\Eloquent\Collection|ProductSet[] $productSets
 * @property integer $qty
 */
class ProductItem extends Model
{
    protected $table = 'product_item';
    protected $guarded = [];
    protected $casts = [
        'pic' => 'array',
        'cost' => 'array',
        'price' => 'array',
        'qty_enable' => 'boolean',
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

    public function productQuantities()
    {
        return $this->hasMany(ProductQuantity::class, 'item_id', 'id');
    }

    public function productPackages()
    {
        return $this->hasMany(ProductPackage::class, 'item_sku', 'sku');
    }

    public function productSets()
    {
        return $this->belongsToMany(ProductSet::class, 'product_package', 'item_sku', 'set_sku', 'sku', 'sku');
    }

    /**
     * @return integer
     */
    public function getQtyAttribute()
    {
        if ($this->qty_enable) {
            if ($lastQuantity = $this->productQuantities->sortByDesc('id')->first()) {
                /** @var ProductQuantity $lastQuantity */
                return $lastQuantity->summary;
            }
            return 0;
        }
        return 999999;
    }
}
