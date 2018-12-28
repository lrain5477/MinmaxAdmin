<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WebDataRequest
 */
class WebDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
                    'WebData.active' => 'required|boolean',
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
            'WebData.website_name' => __('MinmaxBase::models.WebData.website_name'),
            'WebData.system_email' => __('MinmaxBase::models.WebData.system_email'),
            'WebData.system_url' => __('MinmaxBase::models.WebData.system_url'),
            'WebData.company.name' => __('MinmaxBase::models.WebData.company.name'),
            'WebData.contact.phone' => __('MinmaxBase::models.WebData.contact.phone'),
            'WebData.contact.email' => __('MinmaxBase::models.WebData.contact.email'),
            'WebData.contact.map' => __('MinmaxBase::models.WebData.contact.map'),
            'WebData.active' => __('MinmaxBase::models.WebData.active'),
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
