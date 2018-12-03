<?php

namespace Minmax\Base\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

class WebDataRequest extends FormRequest
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
                return $this->user('admin')->can('webDataEdit');
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
            default:
                return [
                    'WebData.website_name' => 'required|string',
                    'WebData.system_email' => 'required|email',
                    'WebData.system_url' => 'required|url',
                    'WebData.company' => 'required|array',
                    'WebData.company.name' => 'required|string',
                    'WebData.contact' => 'required|array',
                    'WebData.contact.phone' => 'required|string',
                    'WebData.contact.email' => 'required|email',
                    'WebData.contact.map' => 'nullable|url',
                    'WebData.seo' => 'nullable|array',
                    'WebData.options' => 'nullable|array',
                    'WebData.active' => 'required|in:1,0',
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
            'WebData.website_name' => __('models.WebData.website_name'),
            'WebData.system_email' => __('models.WebData.system_email'),
            'WebData.system_url' => __('models.WebData.system_url'),
            'WebData.company.name' => __('models.WebData.company.name'),
            'WebData.contact.phone' => __('models.WebData.contact.phone'),
            'WebData.contact.email' => __('models.WebData.contact.email'),
            'WebData.contact.map' => __('models.WebData.contact.map'),
            'WebData.active' => __('models.WebData.active'),
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
            LogHelper::system('admin', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
        }
    }
}
