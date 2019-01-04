<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WebMenu
 * @property string $id
 * @property string $parent_id
 * @property string $title
 * @property string $uri
 * @property string $controller
 * @property string $model
 * @property string $link
 * @property string $permission_key
 * @property array $options
 * @property integer $sort
 * @property boolean $editable
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class WebMenu extends Model
{
    protected $table = 'web_menu';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'editable' => 'boolean',
        'active' => 'boolean',
    ];

    public $incrementing = false;

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }
}