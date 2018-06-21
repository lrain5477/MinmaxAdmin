<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorldCountry extends Model
{
    protected $table = 'world_country';
    protected $primaryKey = 'guid';
    public $incrementing = false;
    protected $fillable = [
        'guid', 'lang', 'title', 'code', 'name', 'icon', 'active'
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
            'code' => 'required|string',
            'name' => 'nullable|string',
            'active' => 'required|in:1,0',
        ];
    }

    public function worldState()
    {
        return $this->hasMany('App\Models\WorldState', 'country_id', 'guid')->where(['lang' => app()->getLocale()]);
    }
}
