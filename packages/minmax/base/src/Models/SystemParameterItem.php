<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemParameterItem
 * @property integer $id
 * @property integer $group_id
 * @property string $value
 * @property string $label
 * @property array $options
 * @property integer $sort
 * @property boolean $active
 * @property SystemParameterGroup $systemParameterGroup
 */
class SystemParameterItem extends Model
{
    protected $table = 'system_parameter_item';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
    ];

    public $timestamps = false;

    public function getLabelAttribute()
    {
        return langDB($this->getAttributeFromArray('label'));
    }

    public function systemParameterGroup()
    {
        return $this->belongsTo(SystemParameterGroup::class, 'group_id', 'id');
    }
}
