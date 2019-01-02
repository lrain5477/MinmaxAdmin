<?php

namespace Minmax\Io\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IoConstruct
 * @property integer $id
 * @property string $title
 * @property string $uri
 * @property boolean $import_enable
 * @property boolean $export_enable
 * @property string $import_view
 * @property string $export_view
 * @property string $controller
 * @property string $example
 * @property string $filename
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|IoRecord[] $ioRecords
 */
class IoConstruct extends Model
{
    protected $table = 'io_construct';
    protected $guarded = [];
    protected $casts = [
        'import_enable' => 'boolean',
        'export_enable' => 'boolean',
        'active' => 'boolean',
    ];

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getFilenameAttribute()
    {
        return langDB($this->getAttributeFromArray('filename'));
    }

    public function ioRecords()
    {
        return $this->hasMany(IoRecord::class, 'uri', 'uri');
    }
}
