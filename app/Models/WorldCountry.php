<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldCountry
 * @property string $guid
 * @property string $lang
 * @property string $title
 * @property string $code
 * @property string $name
 * @property string $icon
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $worldState
 */
class WorldCountry extends Model
{
    protected $table = 'world_country';
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
