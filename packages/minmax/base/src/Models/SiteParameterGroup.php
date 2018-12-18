<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SiteParameterGroup
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property array $options
 * @property boolean $active
 * @property boolean $editable
 * @property \Illuminate\Database\Eloquent\Collection|SiteParameterItem[] $siteParameterItems
 */
class SiteParameterGroup extends Model
{
    protected $table = 'site_parameter_group';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
        'editable' => 'boolean',
    ];

    public $timestamps = false;

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function siteParameterItems()
    {
        return $this->hasMany(SiteParameterItem::class, 'group_id', 'id');
    }
}
