<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebData extends Model
{
    protected $table = 'web_data';
    protected $fillable = [
        'guid', 'lang', 'website_name', 'system_email', 'system_url',
        'company_name', 'company_name_en', 'company_id',
        'phone', 'fax', 'email', 'address', 'map_lng', 'map_lat', 'map_url',
        'link_facebook', 'link_youtube',
        'seo_description', 'seo_keywords', 'google_analytics',
        'active', 'offline_text',
    ];

    public static function rules()
    {
        return [
            'website_name' => 'required|string',
            'system_email' => 'required|email',
            'system_url' => 'required|url',
            'email' => 'nullable|email',
            'map_url' => 'nullable|url',
            'link_facebook' => 'nullable|url',
            'link_youtube' => 'nullable|url',
            'active' => 'required|in:1,0',
        ];
    }
}
