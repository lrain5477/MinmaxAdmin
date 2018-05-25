<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterItem extends Model
{
    protected $table = 'parameter_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guid', 'lang', 'group', 'title', 'value', 'class', 'sort', 'active',
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
