<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

/**
 * Class Permission
 * @property integer $id
 * @property string $guard
 * @property string $group
 * @property string $name
 * @property string $label
 * @property string $display_name
 * @property string $description
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Permission extends LaratrustPermission
{
    protected $table = 'permissions';
    protected $guarded = [];
}