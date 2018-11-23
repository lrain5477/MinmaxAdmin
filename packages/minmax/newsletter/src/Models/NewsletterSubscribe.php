<?php

namespace Minmax\Newsletter\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsletterSubscribe
 * @property string $email
 * @property \Illuminate\Support\Carbon $created_at
 */
class NewsletterSubscribe extends Model
{
    protected $table = 'newsletter_subscribe';
    protected $primaryKey = 'email';
    protected $guarded = [];

    const UPDATED_AT = null;

    public $incrementing = false;
}