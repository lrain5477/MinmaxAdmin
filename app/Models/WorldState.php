<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorldState extends Model
{
    protected $table = 'world_state';
    protected $primaryKey = 'guid';
    public $incrementing = false;
    protected $fillable = [
        'guid', 'lang', 'country_id', 'title', 'code', 'name', 'active'
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
            'country_id' => 'required|string|exists:world_country,guid',
            'title' => 'required|string',
            'code' => 'required|string',
            'name' => 'nullable|string',
            'active' => 'required|in:1,0',
        ];
    }

    public function worldCity()
    {
        return $this->hasMany('App\Models\WorldCity', 'state_id', 'guid')->where(['lang' => app()->getLocale()]);
    }

    public function worldCountry()
    {
        return $this->hasOne('App\Models\WorldCountry', 'guid', 'country_id')->where(['lang' => app()->getLocale()]);
    }
}
