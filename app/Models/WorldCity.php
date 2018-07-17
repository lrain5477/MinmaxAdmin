<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldCity
 * @property string $guid
 * @property string $lang
 * @property string $state_id
 * @property string $title
 * @property string $code
 * @property string $name
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\WorldState $worldState
 */
class WorldCity extends Model
{
    protected $table = 'world_city';
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
            'state_id' => 'required|string|exists:world_state,guid',
            'title' => 'required|string',
            'code' => 'required|string',
            'name' => 'nullable|string',
            'active' => 'required|in:1,0',
        ];
    }

    public function worldState()
    {
        return $this->hasOne('App\Models\WorldState', 'guid', 'state_id')->where(['lang' => app()->getLocale()]);
    }
}
