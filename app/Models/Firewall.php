<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firewall extends Model
{
    protected $table = 'firewall';
    protected $fillable = [
        'guid', 'guard', 'ip', 'rule', 'active',
    ];
}