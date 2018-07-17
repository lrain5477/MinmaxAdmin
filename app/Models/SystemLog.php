<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemLog
 * @property integer $id
 * @property string $guard
 * @property string $uri
 * @property string $action
 * @property string $guid
 * @property string $username
 * @property string $ip
 * @property string $note
 * @property integer $result
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class SystemLog extends Model
{
    protected $table = 'system_log';
    protected $guarded = [];

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
}