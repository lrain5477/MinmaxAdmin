<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'language';

    protected $fillable = [
        'guid', 'title', 'codes', 'name', 'icon', 'sort', 'active'
    ];

    public static function rules()
    {
        return [
            'title' => 'required|string',
            'codes' => 'required|string',
            'name' => 'required|string',
            'icon' => 'required|string',
            'sort' => 'required|integer',
            'active' => 'required|in:1,0',
        ];
    }
}
