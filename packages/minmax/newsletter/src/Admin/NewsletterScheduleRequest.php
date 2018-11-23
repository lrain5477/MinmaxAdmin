<?php

namespace App\Http\Requests\Admin;

use App\Helpers\LogHelper;
use Illuminate\Foundation\Http\FormRequest;

class NewsletterScheduleRequest extends FormRequest
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
                 return $this->user('admin')->can('newsletterScheduleEdit');
             case 'POST':
                 return $this->user('admin')->can('newsletterScheduleCreate');
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
            case 'POST':
            default:
                return [
                    'NewsletterSchedule.title' => 'required|string',
                    'NewsletterSchedule.subject' => 'required|string',
                    'NewsletterSchedule.content' => 'required|string',
                    'NewsletterSchedule.schedule_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'NewsletterSchedule.groups' => 'nullable|array',
                    'NewsletterSchedule.objects' => 'nullable|array',
                ];
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
            'NewsletterSchedule.title' => __('models.NewsletterSchedule.title'),
            'NewsletterSchedule.subject' => __('models.NewsletterSchedule.subject'),
            'NewsletterSchedule.content' => __('models.NewsletterSchedule.content'),
            'NewsletterSchedule.schedule_at' => __('models.NewsletterSchedule.schedule_at'),
            'NewsletterSchedule.groups' => __('models.NewsletterSchedule.groups'),
            'NewsletterSchedule.objects' => __('models.NewsletterSchedule.objects'),
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
                case 'PUT':
                    LogHelper::system('admin', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'POST':
                    LogHelper::system('admin', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
