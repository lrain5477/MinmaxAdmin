<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Firewall
 * @property integer $id
 * @property string $guard
 * @property string $ip
 * @property integer $rule
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Firewall extends Model
{
    protected $table = 'firewall';
    protected $guarded = [];
}