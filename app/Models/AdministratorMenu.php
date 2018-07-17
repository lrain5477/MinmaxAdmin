<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdministratorMenu
 * @property integer $id
 * @property string $title
 * @property string $uri
 * @property string $controller
 * @property string $model
 * @property string $class
 * @property string $parent
 * @property string $link
 * @property string $icon
 * @property string $filter
 * @property integer $sort
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\AdministratorMenu $administratorMenu
 */
class AdministratorMenu extends Model
{
    protected $table = 'administrator_menu';
    protected $guarded = [];

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
