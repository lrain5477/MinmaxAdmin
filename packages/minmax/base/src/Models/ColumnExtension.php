<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ColumnExtension
 * @property integer $id
 * @property string $table_name
 * @property string $column_name
 * @property string $sub_column_name
 * @property string $title
 * @property array $options
 * @property integer $sort
 * @property boolean $active
 */
class ColumnExtension extends Model
{
    protected $table = 'column_extension';
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
}
