<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdministratorMenu
 * @property string $guid
 * @property string $title
 * @property string $uri
 * @property string $controller
 * @property string $model
 * @property string $class
 * @property string $parent_id
 * @property string $link
 * @property string $icon
 * @property integer $sort
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class AdministratorMenu extends Model
{
    protected $table = 'administrator_menu';
    protected $primaryKey = 'guid';
    protected $guarded = [];

    public $incrementing = false;
}
