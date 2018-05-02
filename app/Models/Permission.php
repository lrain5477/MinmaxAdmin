<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'guard', 'name', 'group', 'label', 'display_name', 'description',
    ];

    public static function getIndexKey() {
        return 'id';
    }

    public static function rules()
    {
        return [
            'guard' => 'required|in:admin,merchant',
            'name' => 'required|string',
            'display_name' => 'required|string',
            'group' => 'required|string',
            'label' => 'required|string',
            'active' => 'required|in:1,0',
        ];
    }

    /**
     * Many-to-Many relations with role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'permission_role', 'permission_id', 'role_id');
    }
}