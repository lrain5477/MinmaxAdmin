<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminMenu
 * @property string $guid
 * @property string $title
 * @property string $uri
 * @property string $controller
 * @property string $model
 * @property string $class
 * @property string $parent_id
 * @property string $link
 * @property string $icon
 * @property string $permission_key
 * @property string $filter
 * @property string $keeps
 * @property integer $sort
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\AdminMenuItem $adminMenuItem
 */
class AdminMenu extends Model
{
    protected $table = 'admin_menu';
    protected $primaryKey = 'guid';
    protected $guarded = [];

    public $incrementing = false;
}