<?php

namespace Minmax\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductMarket
 * @property string $id
 * @property string $code
 * @property string $title
 * @property string $admin_id
 * @property array $details
 * @property array $options
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|ProductPackage[] $productPackages
 */
class ProductMarket extends Model
{
    protected $table = 'product_market';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
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

    public function productPackages()
    {
        return $this->belongsToMany(ProductPackage::class, 'product_market_package', 'market_id', 'package_id');
    }
}
