<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministratorMenu extends Model
{
    protected $table = 'administrator_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'uri', 'model', 'class', 'parent', 'link', 'icon', 'filter', 'sort',
    ];

    public static function getIndexKey()
    {
        return 'id';
    }

    /**
     * Return if this model's table with column `lang` and need to use.
     * @return bool
     */
    public static function isMultiLanguage()
    {
        return false;
    }

    public static function rules()
    {
        return [
            'title' => 'required|string',
            'uri' => 'required|string',
            'class' => 'required|string',
            'parent' => 'required',
            'sort' => 'nullable|integer',
        ];
    }

    public function administratorMenu($getChildren = false) {
        if($getChildren) {
            return $this->hasMany('App\Models\AdministratorMenu', 'parent', 'uri');
        } else {
            return $this->hasOne('App\Models\AdministratorMenu', 'uri', 'parent');
        }
    }
}
