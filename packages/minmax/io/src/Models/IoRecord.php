<?php

namespace Minmax\Io\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IoRecord
 * @property integer $id
 * @property string $title
 * @property string $uri
 * @property string $type
 * @property array $errors
 * @property integer $total
 * @property integer $success
 * @property boolean $result
 * @property string $file
 * @property \Illuminate\Support\Carbon $created_at
 */
class IoRecord extends Model
{
    protected $table = 'io_record';
    protected $guarded = [];
    protected $casts = [
        'errors' => 'array',
        'result' => 'boolean',
    ];

    const UPDATED_AT = null;
}
