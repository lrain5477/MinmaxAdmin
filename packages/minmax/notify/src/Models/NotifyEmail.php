<?php

namespace Minmax\Notify\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NotifyEmail
 * @property integer $id
 * @property string $title
 * @property boolean $notifiable
 * @property array $receivers
 * @property string $custom_subject
 * @property string $custom_preheader
 * @property string $custom_editor
 * @property string $custom_mailable
 * @property string $admin_subject
 * @property string $admin_preheader
 * @property string $admin_editor
 * @property string $admin_mailable
 * @property array $replacements
 * @property boolean $queueable
 * @property integer $sort
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class NotifyEmail extends Model
{
    protected $table = 'notify_email';
    protected $guarded = [];
    protected $casts = [
        'notifiable' => 'boolean',
        'receivers' => 'array',
        'queueable' => 'boolean',
        'active' => 'boolean',
    ];

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getCustomSubjectAttribute()
    {
        return langDB($this->getAttributeFromArray('custom_subject'));
    }

    public function getCustomPreheaderAttribute()
    {
        return langDB($this->getAttributeFromArray('custom_preheader'));
    }

    public function getCustomEditorAttribute()
    {
        return langDB($this->getAttributeFromArray('custom_editor'));
    }

    public function getAdminSubjectAttribute()
    {
        return langDB($this->getAttributeFromArray('admin_subject'));
    }

    public function getAdminPreheaderAttribute()
    {
        return langDB($this->getAttributeFromArray('admin_preheader'));
    }

    public function getAdminEditorAttribute()
    {
        return langDB($this->getAttributeFromArray('admin_editor'));
    }

    public function getReplacementsAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('replacements')), true);
    }
}
