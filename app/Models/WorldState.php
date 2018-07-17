<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldState
 * @property string $guid
 * @property string $lang
 * @property string $country_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $worldCity
 * @property \App\Models\WorldCountry $worldCountry
 */
class WorldState extends Model
{
    protected $table = 'world_state';
    protected $primaryKey = 'guid';
    public $incrementing = false;
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
