<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MerchantMenuItem
 * @property integer $id
 * @property string $guid
 * @property string $lang
 * @property string $title
 * @property string $uri
 * @property string $controller
 * @property string $model
 * @property string $class
 * @property string $parent
 * @property string $link
 * @property string $icon
 * @property string $permission_key
 * @property string $filter
 * @property string $keeps
 * @property integer $sort
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\MerchantMenuClass $merchantMenuClass
 * @property \App\Models\MerchantMenuItem $merchantMenuItem
 */
class MerchantMenuItem extends Model
{
    protected $table = 'merchant_menu_item';
    protected $guarded = [];

    public static function getIndexKey()
    {
        return 'guid';
    }

    /**
     * Return if this model's table with column `lang` and need to use.
     * @return bool
     */
    public static function isMultiLanguage()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'title' => 'required|string',
            'uri' => 'required|string',
            'class' => 'required|string',
            'parent' => 'required',
            'sort' => 'nullable|integer',
            'active' => 'required|in:1,0',
        ];
    }

    public function merchantMenuClass() {
        return $this->hasOne('App\Models\MerchantMenuClass', 'guid', 'class');
    }

    public function merchantMenuItem($getChildren = false) {
        if($getChildren) {
            return $this->hasMany('App\Models\MerchantMenuItem', 'parent', 'guid');
        } else {
            return $this->hasOne('App\Models\MerchantMenuItem', 'guid', 'parent');
        }
    }
}
