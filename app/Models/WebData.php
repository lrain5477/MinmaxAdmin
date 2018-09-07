<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WebData
 * @property string $guid
 * @property string $guard
 * @property string $website_name
 * @property string $system_email
 * @property string $system_url
 * @property array $system_logo
 * @property array $company
 * @property array $contact
 * @property array $social
 * @property array $seo
 * @property string $google_analytics
 * @property string $offline_text
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class WebData extends Model
{
    protected $table = 'web_data';
    protected $primaryKey = 'guid';
    protected $guarded = ['guard'];
    protected $casts = [
        'system_logo' => 'array',
        'social' => 'array',
    ];

    public $incrementing = false;

    public function getCompanyAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('company')));
    }

    public function getContactAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('contact')));
    }

    public function getSocialAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('social')));
    }

    public function getSeoAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('seo')));
    }

    public function getOfflineTextAttribute()
    {
        return langDB($this->getAttributeFromArray('offline_text'));
    }
}
