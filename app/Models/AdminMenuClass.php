<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminMenuClass
 * @property integer $id
 * @property string $guid
 * @property string $title
 * @property integer $sort
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $adminMenuItem
 */
class AdminMenuClass extends Model
{
    protected $table = 'admin_menu_class';
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
        return false;
    }

    public static function rules()
    {
        return [
            'title' => 'required|string',
            'sort' => 'nullable|integer',
            'active' => 'required|in:1,0',
        ];
    }

    public function adminMenuItem() {
        return $this->hasMany('App\Models\AdminMenuItem', 'class', 'guid');
    }
}