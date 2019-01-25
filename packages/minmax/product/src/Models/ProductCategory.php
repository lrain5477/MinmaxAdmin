<?php

namespace Minmax\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Minmax\Base\Models\Role;

/**
 * Class ProductCategory
 * @property string $id
 * @property string $title
 * @property array $details
 * @property string $parent_id
 * @property boolean $visible
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|ProductSet[] $productSets
 * @property \Illuminate\Database\Eloquent\Collection|Role[] $roles
 */
class ProductCategory extends Model
{
    protected $table = 'product_category';
    protected $guarded = [];
    protected $casts = [
        'visible' => 'boolean',
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
        return $this->belongsToMany(ProductSet::class, 'product_category_set', 'category_id', 'set_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'product_category_role', 'category_id', 'role_id');
    }
}
