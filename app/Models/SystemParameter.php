<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemParameter
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property array $options
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class SystemParameter extends Model
{
    protected $table = 'system_parameter';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
    ];
}
