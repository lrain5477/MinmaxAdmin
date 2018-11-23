<?php

namespace App\Http\Requests\Admin;

use App\Helpers\LogHelper;
use Illuminate\Foundation\Http\FormRequest;

class NewsletterTemplateRequest extends FormRequest
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
                 return $this->user('admin')->can('newsletterTemplateEdit');
             case 'POST':
                 return $this->user('admin')->can('newsletterTemplateCreate');
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
                    'NewsletterTemplate.title' => 'required|string',
                    'NewsletterTemplate.subject' => 'required|string',
                    'NewsletterTemplate.content' => 'required|string',
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
            'NewsletterTemplate.title' => __('models.NewsletterTemplate.title'),
            'NewsletterTemplate.subject' => __('models.NewsletterTemplate.subject'),
            'NewsletterTemplate.content' => __('models.NewsletterTemplate.content'),
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
