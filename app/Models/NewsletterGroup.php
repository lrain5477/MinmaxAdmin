<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsletterGroup
 * @property integer $id
 * @property string $title
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class NewsletterGroup extends Model
{
    protected $table = 'newsletter_group';
    protected $guarded = [];
}