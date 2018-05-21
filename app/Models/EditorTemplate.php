<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditorTemplate extends Model
{
    protected $table = 'editor_template';
    protected $fillable = [
        'guid', 'lang', 'guard', 'category', 'title', 'description', 'editor', 'sort', 'active',
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
            'guard' => 'required|in:admin,merchant,web',
            'category' => 'alpha',
            'title' => 'string',
            'editor' => 'required',
            'active' => 'required|in:1,0',
        ];
    }
}
