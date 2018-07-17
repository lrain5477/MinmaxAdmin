<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PermissionRole
 * @property integer $permission_id
 * @property integer $role_id
 */
class PermissionRole extends Model
{
    protected $table = 'permission_role';
    public $timestamps = false;
    protected $guarded = [];
}
