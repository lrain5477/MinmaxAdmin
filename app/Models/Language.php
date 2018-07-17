<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * @property integer $id
 * @property string $guid
 * @property string $title
 * @property string $codes
 * @property string $name
 * @property string $icon
 * @property integer $sort
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Language extends Model
{
    protected $table = 'language';
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
            'codes' => 'required|string',
            'name' => 'required|string',
            'icon' => 'required|string',
            'sort' => 'required|integer',
            'active' => 'required|in:1,0',
        ];
    }
}
