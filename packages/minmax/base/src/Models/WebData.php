<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WebData
 * @property string $id
 * @property string $guard
 * @property string $website_name
 * @property string $system_language
 * @property string $system_email
 * @property string $system_url
 * @property array $system_logo
 * @property array $company
 * @property array $contact
 * @property array $social
 * @property array $seo
 * @property array $options
 * @property string $offline_text
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class WebData extends Model
{
    protected $table = 'web_data';
    protected $guarded = ['guard'];
    protected $casts = [
        'system_logo' => 'array',
        'social' => 'array',
        'active' => 'boolean',
    ];

    public $incrementing = false;

    public function getWebsiteNameAttribute()
    {
        return langDB($this->getAttributeFromArray('website_name'));
    }

    public function getCompanyAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('company')), true);
    }

    public function getContactAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('contact')), true);
    }

    public function getSeoAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('seo')), true);
    }

    public function getOptionsAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('options')), true);
    }

    public function getOfflineTextAttribute()
    {
        return langDB($this->getAttributeFromArray('offline_text'));
    }
}
