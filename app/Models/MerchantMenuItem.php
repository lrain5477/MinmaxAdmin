<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantMenuItem extends Model
{
    protected $table = 'merchant_menu_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang', 'guid', 'title', 'uri', 'model', 'class', 'parent', 'link', 'icon', 'filter', 'keeps', 'sort', 'active',
    ];

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
