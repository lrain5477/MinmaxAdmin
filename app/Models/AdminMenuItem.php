<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenuItem extends Model
{
    protected $table = 'admin_menu_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang', 'guid', 'title', 'uri', 'model', 'class', 'parent', 'link', 'icon', 'filter', 'keeps', 'sort', 'active',
    ];

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

    public function adminMenuClass() {
        return $this->hasOne('App\Models\AdminMenuClass', 'guid', 'class');
    }

    public function adminMenuItem($getChildren = false) {
        if($getChildren) {
            return $this->hasMany('App\Models\AdminMenuItem', 'parent', 'guid');
        } else {
            return $this->hasOne('App\Models\AdminMenuItem', 'guid', 'parent');
        }
    }
}
