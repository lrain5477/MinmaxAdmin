<?php

namespace Minmax\Notify\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class NotifyEmailRequest
 */
class NotifyEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'PUT':
                return $this->user('admin')->can('notifyEmailEdit');
            default:
                return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'PUT':
                return [
                    'NotifyEmail.title' => 'required|string',
                    'NotifyEmail.notifiable' => 'required|boolean',
                    'NotifyEmail.receivers' => 'nullable|array',
                    'NotifyEmail.custom_subject' => 'nullable|string',
                    'NotifyEmail.custom_preheader' => 'nullable|string',
                    'NotifyEmail.custom_editor' => 'nullable|string',
                    'NotifyEmail.admin_subject' => 'nullable|string',
                    'NotifyEmail.admin_preheader' => 'nullable|string',
                    'NotifyEmail.admin_editor' => 'nullable|string',
                    'NotifyEmail.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [];
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'NotifyEmail.title' => __('MinmaxNotify::models.NotifyEmail.title'),
            'NotifyEmail.notifiable' => __('MinmaxNotify::models.NotifyEmail.notifiable'),
            'NotifyEmail.receivers' => __('MinmaxNotify::models.NotifyEmail.receivers'),
            'NotifyEmail.custom_subject' => __('MinmaxNotify::models.NotifyEmail.custom_subject'),
            'NotifyEmail.custom_preheader' => __('MinmaxNotify::models.NotifyEmail.custom_preheader'),
            'NotifyEmail.custom_editor' => __('MinmaxNotify::models.NotifyEmail.custom_editor'),
            'NotifyEmail.admin_subject' => __('MinmaxNotify::models.NotifyEmail.admin_subject'),
            'NotifyEmail.admin_preheader' => __('MinmaxNotify::models.NotifyEmail.admin_preheader'),
            'NotifyEmail.admin_editor' => __('MinmaxNotify::models.NotifyEmail.admin_editor'),
            'NotifyEmail.active' => __('MinmaxNotify::models.NotifyEmail.active'),
        ];
    }

    /**
     * 設定驗證器實例。
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            switch ($this->method()) {
                case 'POST':
                    LogHelper::system('administrator', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'PUT':
                    LogHelper::system('administrator', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
