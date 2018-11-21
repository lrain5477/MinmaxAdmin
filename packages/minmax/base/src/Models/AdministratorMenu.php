<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdministratorMenu
 * @property string $id
 * @property string $parent_id
 * @property string $title
 * @property string $uri
 * @property string $controller
 * @property string $model
 * @property string $link
 * @property string $icon
 * @property integer $sort
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class AdministratorMenu extends Model
{
    protected $table = 'administrator_menu';
    protected $guarded = [];

    public $incrementing = false;
}
