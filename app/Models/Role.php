<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;

/**
 * Class Role
 * @property integer $id
 * @property string $guard
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Role extends LaratrustRole
{
    protected $table = 'roles';
    protected $guarded = [];
}