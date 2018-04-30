<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenuClass extends Model
{
    protected $table = 'admin_menu_class';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guid', 'title', 'sort', 'active',
    ];

    public static function rules()
    {
        return [
            'title' => 'required|string',
            'sort' => 'nullable|integer',
            'active' => 'required|in:1,0',
        ];
    }

    public function adminMenuItem() {
        return $this->hasMany('App\Models\AdminMenuItem', 'class', 'guid');
    }
}