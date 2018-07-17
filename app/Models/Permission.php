<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @property integer $id
 * @property string $guard
 * @property string $name
 * @property string $group
 * @property string $label
 * @property string $display_name
 * @property string $description
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $roles
 */
class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'guard', 'name', 'group', 'label', 'display_name', 'description',
    ];

    public static function getIndexKey()
    {
        return 'id';
    }

    /**
     * Return if this model's table with column `lang` and need to use.
     * @return bool
     */
    public static function isMultiLanguage()
    {
        return false;
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