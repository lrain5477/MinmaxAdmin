<?php

namespace Minmax\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductQuantity
 * @property integer $id
 * @property string $item_id
 * @property integer $amount
 * @property string $remark
 * @property integer $summary
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Minmax\Product\Models\ProductItem $productItem
 */
class ProductQuantity extends Model
{
    protected $table = 'product_quantity';
    protected $guarded = [];
    protected $casts = [
        'pic' => 'array',
        'cost' => 'array',
        'price' => 'array',
        'active' => 'boolean',
    ];

    const UPDATED_AT = null;

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class, 'item_id', 'id');
    }
}
