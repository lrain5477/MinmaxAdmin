<?php

namespace Minmax\Newsletter\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsletterTemplate
 * @property integer $id
 * @property string $title
 * @property integer $subject
 * @property integer $content
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class NewsletterTemplate extends Model
{
    protected $table = 'newsletter_template';
    protected $guarded = [];
}