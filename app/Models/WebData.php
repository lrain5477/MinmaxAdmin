<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WebData
 * @property integer $id
 * @property string $guid
 * @property string $lang
 * @property string $website_key
 * @property string $website_name
 * @property string $system_email
 * @property string $system_url
 * @property string $company_name
 * @property string $company_name_en
 * @property string $company_id
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $address
 * @property string $map_lng
 * @property string $map_lat
 * @property string $map_url
 * @property string $link_facebook
 * @property string $link_youtube
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $google_analytics
 * @property string $offline_text
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class WebData extends Model
{
    protected $table = 'web_data';
    protected $guarded = ['website_key'];

    public static function getIndexKey()
    {
        return 'guid';
    }

    /**
     * Return if this model's table with column `lang` and need to use.
     * @return bool
     */
    public static function isMultiLanguage()
    {
        return true;
    }

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
