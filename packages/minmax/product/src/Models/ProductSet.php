<?php

namespace Minmax\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 * @property array $specifications
 * @property array $tags
 * @property array $seo
 * @property boolean $searchable
 * @property boolean $visible
 * @property array $properties
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
        'specifications' => 'array',
        'tags' => 'array',
        'searchable' => 'boolean',
        'visible' => 'boolean',
        'active' => 'boolean',
        'properties' => 'array',
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

    /**
     * Get product's price.
     * @param  string $type can be 'sell' or 'advice'
     * @param  string $market is market's code
     * @param  string $currency
     * @param  boolean $withSymbol
     * @return mixed
     */
    public function price($type = 'sell', $market = null, $currency = null, $withSymbol = false)
    {
        $currentTime = Carbon::now();
        $currency = $currency ?? getCurrency(null, app()->getLocale());

        $package = $this->productPackages
            ->filter(function ($item) use ($currentTime, $market) {
                /**
                 * @var ProductPackage $item
                 * @var \Illuminate\Database\Eloquent\Collection|ProductMarket[] $markets
                 */
                $markets = $item->productMarkets->sortBy('sort');

                if ($markets->count() == 0) {
                    $marketBoolean = true;
                } else {
                    if (is_null($market)) {
                        $marketBoolean = intval($markets->first()->sort) == 1;
                    } else {
                        $marketBoolean = $markets->where('code', $market)->count() > 0;
                    }
                }

                return $item->active
                    && $marketBoolean
                    && (is_null($item->start_at) || $item->start_at->lessThanOrEqualTo($currentTime))
                    && (is_null($item->end_at) || $item->end_at->lessThanOrEqualTo($currentTime));
            });

        if ($package->count() < 1) {
            return null;
        }

        if ($withSymbol) {
            $prefix = getCurrency('symbol', app()->getLocale());
            return "{$prefix} " . $package
                    ->sum(function ($item) use ($currency, $type) {
                        /** @var ProductPackage $item */
                        return array_get($item->getAttribute("price_{$type}"), $currency, 0);
                    });
        }

        return $package
            ->sum(function ($item) use ($currency, $type) {
                /** @var ProductPackage $item */
                return array_get($item->getAttribute("price_{$type}"), $currency, 0);
            });
    }

    public function qty($market = null)
    {
        $productItems = $this->productItems;

        if (is_null($market)) {
            $productPackages = $this->productPackages->where('active', true);
        } else {
            $productPackages = $this->productPackages
                ->filter(function ($item) use ($market) {
                    /** @var ProductPackage $item */
                    return $item->active
                        && ($item->productMarkets->count() == 0 || $item->productMarkets->where('code', $market)->count() > 0);
                });
        }

        $quantityAmount = 0;

        /** @var \Illuminate\Database\Eloquent\Collection|ProductPackage[] $productPackages */
        foreach ($productPackages as $productPackage) {
            /** @var ProductItem $productItem */
            $productItem = $productItems->firstWhere('sku', $productPackage->item_sku);

            if (is_null($productItem) || !$productItem->active) {
                $quantityAmount = 0;
                break;
            }

            if ($productItem->qty < $productPackage->amount) {
                $quantityAmount = 0;
                break;
            }

            $thisAmount = floor($productItem->qty / $productPackage->amount);

            $quantityAmount = ($quantityAmount > 0 && $quantityAmount > $thisAmount) ? $thisAmount : $quantityAmount;
        }

        return $quantityAmount;
    }
}
