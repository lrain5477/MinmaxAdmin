<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ParameterGroup
 * @property integer $id
 * @property string $guid
 * @property string $code
 * @property string $title
 * @property integer $admin
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $parameterItem
 */
class ParameterGroup extends Model
{
    protected $table = 'parameter_group';
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
