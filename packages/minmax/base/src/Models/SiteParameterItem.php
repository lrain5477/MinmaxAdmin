<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SiteParameterItem
 * @property integer $id
 * @property integer $group_id
 * @property string $value
 * @property string $label
 * @property array $options
 * @property integer $sort
 * @property boolean $active
 * @property SiteParameterGroup $siteParameterGroup
 */
class SiteParameterItem extends Model
{
    protected $table = 'site_parameter_item';
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

    public function siteParameterGroup()
    {
        return $this->belongsTo(SiteParameterGroup::class, 'group_id', 'id');
    }
}
