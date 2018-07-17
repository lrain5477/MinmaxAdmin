<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ParameterItem
 * @property integer $id
 * @property string $guid
 * @property string $lang
 * @property string $group
 * @property string $title
 * @property string $value
 * @property string $class
 * @property integer $sort
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\ParameterGroup $parameterGroup
 */
class ParameterItem extends Model
{
    protected $table = 'parameter_item';
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
            'group' => 'required|string',
            'title' => 'required|string',
            'value' => 'required|string',
            'active' => 'required|in:1,0',
        ];
    }

    public function parameterGroup() {
        return $this->hasOne('App\Models\ParameterGroup', 'guid', 'group');
    }
}
