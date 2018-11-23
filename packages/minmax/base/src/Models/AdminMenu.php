<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminMenu
 * @property string $id
 * @property string $parent_id
 * @property string $title
 * @property string $uri
 * @property string $controller
 * @property string $model
 * @property string $link
 * @property string $icon
 * @property string $permission_key
 * @property array $options
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class AdminMenu extends Model
{
    protected $table = 'admin_menu';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
    ];

    public $incrementing = false;
}