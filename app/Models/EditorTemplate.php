<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EditorTemplate
 * @property integer $id
 * @property string $guid
 * @property string $lang
 * @property string $guard
 * @property string $category
 * @property string $title
 * @property string $description
 * @property string $editor
 * @property integer $sort
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
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
