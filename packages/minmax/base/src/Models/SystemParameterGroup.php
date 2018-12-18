<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemParameterGroup
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property array $options
 * @property boolean $active
 * @property \Illuminate\Database\Eloquent\Collection|SystemParameterItem[] $systemParameterItems
 */
class SystemParameterGroup extends Model
{
    protected $table = 'system_parameter_group';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
    ];

    public $timestamps = false;

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function systemParameterItems()
    {
        return $this->hasMany(SystemParameterItem::class, 'group_id', 'id');
    }
}
