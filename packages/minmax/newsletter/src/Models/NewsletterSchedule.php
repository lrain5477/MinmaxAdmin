<?php

namespace Minmax\Newsletter\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsletterSchedule
 * @property integer $id
 * @property string $title
 * @property integer $subject
 * @property integer $content
 * @property \Illuminate\Support\Carbon $schedule_at
 * @property array $groups
 * @property array $objects
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class NewsletterSchedule extends Model
{
    protected $table = 'newsletter_schedule';
    protected $guarded = [];
    protected $dates = ['schedule_at', 'created_at', 'updated_at'];
    protected $casts = [
        'groups' => 'array',
        'objects' => 'array',
    ];
}