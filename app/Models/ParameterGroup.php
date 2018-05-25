<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterGroup extends Model
{
    protected $table = 'parameter_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guid', 'code', 'title', 'admin', 'active',
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
        return false;
    }

    public static function rules()
    {
        return [
            'code' => 'required|string',
            'title' => 'required|string',
            'admin' => 'required|in:1,0',
            'active' => 'required|in:1,0',
        ];
    }

    public function parameterItem() {
        return $this->hasMany('App\Models\ParameterItem', 'group', 'guid')->where(['lang' => app()->getLocale()])->orderBy('sort');
    }
}
